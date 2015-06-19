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

use Http\Client\HttpClient;
use Http\Client\Message\InternalRequest;
use Http\Client\Message\InternalMessageFactory;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Http\Message\MessageFactoryGuesser;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\RequestInterface;

use Http\Adapter\Normalizer\HeaderNormalizer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Client implements HttpClient
{
    use HttpClientTemplate;

    /**
     * @var HttpAdapter
     */
    private $adapter;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @param HttpAdapter|null    $adapter
     * @param MessageFactory|null $messageFactory
     */
    public function __construct(HttpAdapter $adapter = null, MessageFactory $messageFactory = null)
    {
        // guess http adapter
        $this->adapter = $adapter;

        if (!isset($messageFactory)) {
            $messageFactory = MessageFactoryDiscovery::find();
        }

        if (!$messageFactory instanceof InternalMessageFactory) {
            $messageFactory = new Message\InternalMessageFactory($messageFactory);
        }

        $this->messageFactory = $messageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function send($method, $uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        if ($data instanceof StreamInterface && !empty($files)) {
            throw new \InvalidArgumentException('A data instance of Psr\Http\Message\StreamInterface and $files parameters should not be passed together.');
        }

        $request = $this->messageFactory->createInternalRequest(
            $method,
            $uri,
            isset($options['protocolVersion']) ? $options['protocolVersion'] : '1.1',
            $headers,
            $data,
            $files
        );

        return $this->sendRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        return $this->adapter->sendRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequests(array $requests)
    {
        return $this->adapter->sendRequests($requests);
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
                $this->configuration->isKeptAlive() ? 'keep-alive' : 'close'
            );
        }

        if (!$internalRequest->hasHeader('Content-Type')) {
            if ($this->configuration->hasContentType()) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    $this->configuration->getContentType()
                );
            } elseif ($contentType && $internalRequest->hasFiles()) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    ConfigurationInterface::CONTENT_TYPE_FORMDATA.'; boundary='.$this->configuration->getBoundary()
                );
            } elseif ($contentType && ($internalRequest->hasAnyData() || $internalRequest->getBody()->getSize() > 0)) {
                $internalRequest = $internalRequest->withHeader(
                    'Content-Type',
                    ConfigurationInterface::CONTENT_TYPE_URLENCODED
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
