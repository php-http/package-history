<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Message;

use Http\Adapter\Normalizer\HeaderNormalizer;
use Phly\Http\Stream;
use Phly\Http\Uri;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MessageFactory implements MessageFactoryInterface
{
    /**
     * @var UriInterface|null
     */
    private $baseUri;

    /**
     * @param UriInterface|string $baseUri
     */
    public function __construct($baseUri = null)
    {
        $this->setBaseUri($baseUri);
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * {@inheritdoc}
     */
    public function hasBaseUri()
    {
        return isset($this->baseUri);
    }

    /**
     * {@inheritdoc}
     */
    public function setBaseUri($baseUri = null)
    {
        if (is_string($baseUri)) {
            $baseUri = new Uri($baseUri);
        }

        $this->baseUri = $baseUri;
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(
        $method,
        $uri,
        $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_1,
        array $headers = [],
        $body = null,
        array $parameters = []
    ) {
        return (new Request(
            $method,
            $this->createUri($uri),
            HeaderNormalizer::normalize($headers),
            $this->createStream($body),
            $parameters
        ))->withProtocolVersion($protocolVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function createInternalRequest(
        $method,
        $uri,
        $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_1,
        array $headers = [],
        $data = [],
        array $files = [],
        array $parameters = []
    ) {
        $body = null;

        if (!is_array($data)) {
            $body = $this->createStream($data);
            $data = $files = [];
        }

        return (new InternalRequest(
            $method,
            $this->createUri($uri),
            HeaderNormalizer::normalize($headers),
            $body !== null ? $body : 'php://memory',
            $data,
            $files,
            $parameters
        ))->withProtocolVersion($protocolVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(
        $statusCode = 200,
        $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_1,
        array $headers = [],
        $body = null,
        array $parameters = []
    ) {
        return (new Response(
            $statusCode,
            HeaderNormalizer::normalize($headers),
            $this->createStream($body),
            $parameters
        ))->withProtocolVersion($protocolVersion);
    }

    /**
     * Creates an uri
     *
     * @param string $uri
     *
     * @return string
     */
    private function createUri($uri)
    {
        if ($this->hasBaseUri() && (stripos($uri, $baseUri = (string) $this->getBaseUri()) === false)) {
            return $baseUri.$uri;
        }

        return $uri;
    }

    /**
     * Creates a stream
     *
     * @param null|resource|string|StreamInterface $body
     *
     * @return StreamInterface
     */
    private function createStream($body)
    {
        if ($body instanceof StreamInterface) {
            $body->rewind();

            return $body;
        }

        if (is_resource($body)) {
            return $this->createStream(new Stream($body));
        }

        $stream = new Stream('php://memory', 'rw');

        if ($body === null) {
            return $stream;
        }

        $stream->write((string) $body);

        return $this->createStream($stream);
    }
}
