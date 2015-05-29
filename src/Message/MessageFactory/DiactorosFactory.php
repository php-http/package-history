<?php

/*
 * This file is part of the Http Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Common\Message\MessageFactory;

use Http\Helper\Normalizer\HeaderNormalizer;
use Http\Message\MessageFactory;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;
use Zend\Diactoros\Uri;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class DiactorosFactory implements MessageFactory
{
    /**
     * {@inheritdoc}
     */
    public function createRequest(
        $method,
        $uri,
        $protocolVersion = '1.1',
        array $headers = [],
        $body = null
    ) {
        return (new Request(
            $uri,
            $method,
            $this->createStream($body),
            HeaderNormalizer::normalize($headers)
        ))->withProtocolVersion($protocolVersion);
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse(
        $statusCode = 200,
        $reasonPhrase = null,
        $protocolVersion = '1.1',
        array $headers = [],
        $body = null
    ) {
        return (new Response(
            $this->createStream($body),
            $statusCode,
            HeaderNormalizer::normalize($headers)
        ))->withProtocolVersion($protocolVersion);
    }

    /**
     * Creates a stream
     *
     * @param string|resource|StreamInterface|null $body
     *
     * @return StreamInterface
     *
     * @throws \InvalidArgumentException If the stream body is invalid
     */
    protected function createStream($body = null)
    {
        if (!$body instanceof StreamInterface) {
            if (is_resource($body)) {
                $body = new Stream($body);
            } else {
                $stream = new Stream('php://memory', 'rw');

                if (isset($body)) {
                    $stream->write((string) $body);
                }

                $body = $stream;
            }
        }

        $body->rewind();

        return $body;
    }
}
