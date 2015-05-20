<?php

/*
 * This file is part of the Http Adapter Core package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core;

use Http\Adapter\Common\Configurable;
use Http\Adapter\Configurable as ConfigurableInterface;
use Http\Adapter\ConfigurableHttpAdapter;
use Http\Adapter\Internal\Message\InternalRequest;
use Http\Adapter\Internal\Message\MessageFactory;
use Http\Adapter\Message\Configurable as ConfigurableMessage;
use Http\Adapter\Normalizer\HeaderNormalizer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class CoreHttpAdapter implements ConfigurableHttpAdapter, ConfigurableInterface
{
    use HttpAdapter;
    use Configurable;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var array
     */
    protected $defaultOptions = [
        'protocolVersion' => '1.1',
        'keepAlive'       => false,
        'boundary'        => '',
        'timeout'         => 10,
        'userAgent'       => 'PHP HTTP Adapter',
    ];

    /**
     * @param array $options
     */
    public function __construct(array $options = [], MessageFactory $messageFactory = null)
    {
        $this->options = array_merge($this->defaultOptions, $options);
        $this->messageFactory = $messageFactory ?: new Message\MessageFactory();
    }

    /**
     * Returns Message Factory
     *
     * @return MessageFactory
     */
    public function getMessageFactory()
    {
        if (!isset($this->messageFactory)) {
            $this->messageFactory = new Message\MessageFactory();
        }

        return $this->messageFactory;
    }

    /**
     * Sets a Message Factory
     *
     * @param MessageFactory $messageFactory
     */
    public function setMessageFactory(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * Prepares the headers
     *
     * @param InternalRequest $internalRequest
     * @param boolean         $associative     TRUE if the prepared headers should be associative else FALSE.
     * @param boolean         $contentType     TRUE if the content type header should be prepared else FALSE.
     * @param boolean         $contentLength   TRUE if the content length header should be prepared else FALSE.
     *
     * @return array
     */
    protected function prepareHeaders(
        InternalRequest &$internalRequest,
        $associative = true,
        $contentType = true,
        $contentLength = false
    ) {
        if (!$internalRequest->hasHeader('Connection')) {
            $internalRequest = $internalRequest->withHeader(
                'Connection',
                $this->getContextOption('keepAlive', $internalRequest) ? 'keep-alive' : 'close'
            );
        }

        if (!$internalRequest->hasHeader('Content-Type')) {
            if ($internalRequest->hasOption('contentType')) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    $this->getContextOption('contentType', $internalRequest)
                );
            } elseif ($contentType && $internalRequest->hasFiles()) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    'multipart/form-data; boundary='.$this->getContextOption('boundary', $internalRequest)
                );
            } elseif ($contentType && ($internalRequest->hasAnyData() || $internalRequest->getBody()->getSize() > 0)) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    'application/x-www-form-urlencoded'
                );
            }
        }

        if ($contentLength && !$internalRequest->hasHeader('Content-Length')
            && ($length = strlen($this->prepareBody($internalRequest))) > 0) {
            $internalRequest = $internalRequest->withHeader('Content-Length', (string) $length);
        }

        if (!$internalRequest->hasHeader('User-Agent')) {
            $internalRequest = $internalRequest->withHeader('User-Agent', $this->getContextOption('userAgent', $internalRequest));
        }

        return HeaderNormalizer::normalize($internalRequest->getHeaders(), $associative);
    }

    /**
     * Prepares the body
     *
     * @param InternalRequest $internalRequest
     *
     * @return string
     */
    protected function prepareBody(InternalRequest $internalRequest)
    {
        if ($internalRequest->getBody()->getSize() > 0) {
            return (string) $internalRequest->getBody();
        }

        if (!$internalRequest->hasFiles()) {
            return http_build_query($internalRequest->getAllData(), null, '&');
        }

        $body = '';

        foreach ($internalRequest->getAllData() as $name => $value) {
            $body .= $this->prepareRawBody($name, $value);
        }

        foreach ($internalRequest->getFiles() as $name => $file) {
            $body .= $this->prepareRawBody($name, $file, true);
        }

        $body .= '--'.$this->getContextOption('boundary', $internalRequest).'--'."\r\n";

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

        $body = '--'.$this->getOption('boundary')."\r\n".'Content-Disposition: form-data; name="'.$name.'"';

        if ($isFile) {
            $body .= '; filename="'.basename($data).'"';
            $data = file_get_contents($data);
        }

        return $body."\r\n\r\n".$data."\r\n";
    }

    /**
     * Prepares the URI
     *
     * @param string $uri
     *
     * @return string
     */
    protected function prepareUri($uri)
    {
        if ($this->hasOption('baseUri') && (stripos($uri, $baseUri = (string) $this->getOption('baseUri')) === false)) {
            return $baseUri.$uri;
        }

        return $uri;
    }

    /**
     * Returns options based on the context
     *
     * @param string                   $option
     * @param ConfigurableMessage|null $configurableMessage
     *
     * @return mixed
     */
    protected function getContextOption($option, ConfigurableMessage $configurableMessage = null)
    {
        if (isset($configurableMessage) && $configurableMessage->hasOption($option)) {
            return $configurableMessage->getOption($option);
        }

        return $this->getOption($option);
    }
}
