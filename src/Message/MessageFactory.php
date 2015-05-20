<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common\Message;

use Http\Message\ClientContextFactory;
use Http\Adapter\Normalizer\HeaderNormalizer;
use Phly\Http\Request;
use Phly\Http\Response;
use Phly\Http\Stream;
use Phly\Http\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MessageFactory implements ClientContextFactory
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
            $this->createUri($uri),
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
     * {@inheritdoc}
     */
    public function createUri($uri)
    {
        if ($uri instanceof UriInterface) {
            return $uri;
        }

        return new Uri($uri);
    }

    /**
     * {@inheritdoc}
     */
    public function createStream($body = null)
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
