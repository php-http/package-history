<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter;

use Http\Adapter\Message\InternalRequestInterface;
use Http\Adapter\Normalizer\HeaderNormalizer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class CoreHttpAdapter implements HttpAdapter
{
    use HttpAdapterTrait;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * @param ConfigurationInterface|null $configuration
     */
    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->setConfiguration($configuration ?: new Configuration());
    }

    /**
     * Returns the configuration
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Sets the configuration
     *
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Prepares the headers
     *
     * @param InternalRequestInterface $internalRequest
     * @param boolean                  $associative     TRUE if the prepared headers should be associative else FALSE.
     * @param boolean                  $contentType     TRUE if the content type header should be prepared else FALSE.
     * @param boolean                  $contentLength   TRUE if the content length header should be prepared else FALSE.
     *
     * @return array
     */
    protected function prepareHeaders(
        InternalRequestInterface &$internalRequest,
        $associative = true,
        $contentType = true,
        $contentLength = false
    ) {
        if (!$internalRequest->hasHeader('Connection')) {
            $internalRequest = $internalRequest->withHeader(
                'Connection',
                $this->configuration->getKeepAlive() ? 'keep-alive' : 'close'
            );
        }

        if (!$internalRequest->hasHeader('Content-Type')) {
            $rawData = (string) $internalRequest->getBody();
            $data = $internalRequest->getAllData();
            $files = $internalRequest->getFiles();

            if ($this->configuration->hasEncodingType()) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    $this->configuration->getEncodingType()
                );
            } elseif ($contentType && !empty($files)) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    ConfigurationInterface::ENCODING_TYPE_FORMDATA.'; boundary='.$this->configuration->getBoundary()
                );
            } elseif ($contentType && (!empty($data) || !empty($rawData))) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    ConfigurationInterface::ENCODING_TYPE_URLENCODED
                );
            }
        }

        if ($contentLength && !$internalRequest->hasHeader('Content-Length')
            && ($length = strlen($this->prepareBody($internalRequest))) > 0) {
            $internalRequest = $internalRequest->withHeader('Content-Length', (string) $length);
        }

        if (!$internalRequest->hasHeader('User-Agent')) {
            $internalRequest = $internalRequest->withHeader('User-Agent', $this->configuration->getUserAgent());
        }

        return HeaderNormalizer::normalize($internalRequest->getHeaders(), $associative);
    }

    /**
     * Prepares the body
     *
     * @param InternalRequestInterface $internalRequest
     *
     * @return string
     */
    protected function prepareBody(InternalRequestInterface $internalRequest)
    {
        $body = (string) $internalRequest->getBody();

        if (!empty($body)) {
            return $body;
        }

        $files = $internalRequest->getFiles();

        if (empty($files)) {
            return http_build_query($internalRequest->getAllData(), null, '&');
        }

        $body = '';

        foreach ($internalRequest->getAllData() as $name => $value) {
            $body .= $this->prepareRawBody($name, $value);
        }

        foreach ($internalRequest->getFiles() as $name => $file) {
            $body .= $this->prepareRawBody($name, $file, true);
        }

        $body .= '--'.$this->configuration->getBoundary().'--'."\r\n";

        return $body;
    }

    /**
     * Prepares the name
     *
     * @param string $name
     * @param string $subName
     *
     * @return string
     */
    protected function prepareName($name, $subName)
    {
        return $name.'['.$subName.']';
    }

    /**
     * Prepares the raw body
     *
     * @param string       $name
     * @param array|string $data
     * @param boolean      $isFile TRUE if the data is a file path else FALSE.
     *
     * @return string
     */
    private function prepareRawBody($name, $data, $isFile = false)
    {
        if (is_array($data)) {
            $body = '';

            foreach ($data as $subName => $subData) {
                $body .= $this->prepareRawBody($this->prepareName($name, $subName), $subData, $isFile);
            }

            return $body;
        }

        $body = '--'.$this->configuration->getBoundary()."\r\n".'Content-Disposition: form-data; name="'.$name.'"';

        if ($isFile) {
            $body .= '; filename="'.basename($data).'"';
            $data = file_get_contents($data);
        }

        return $body."\r\n\r\n".$data."\r\n";
    }
}
