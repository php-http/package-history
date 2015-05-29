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

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Helper\Normalizer\HeaderNormalizer;
use Http\Message\ClientContextFactory;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class GuzzleFactory implements ClientContextFactory
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
        return new Request(
            $method,
            $uri,
            HeaderNormalizer::normalize($headers),
            $body,
            $protocolVersion
        );
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
        return new Response(
            $statusCode,
            HeaderNormalizer::normalize($headers),
            $body,
            $protocolVersion,
            $reasonPhrase
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createUri($uri)
    {
        return \GuzzleHttp\Psr7\uri_for($uri);
    }

    /**
     * {@inheritdoc}
     */
    public function createStream($body = null)
    {
        return \GuzzleHttp\Psr7\stream_for($body);
    }
}
