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

use Http\Message\ClientContextFactory;

/**
 * Can be used with custom logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class ClientContextFactoryDecorator implements ClientContextFactory
{
    /**
     * @var ClientContextFactory
     */
    protected $clientContextFactory;

    /**
     * @param ClientContextFactory $clientContextFactory
     */
    public function __construct(ClientContextFactory $clientContextFactory)
    {
        $this->clientContextFactory = $clientContextFactory;
    }

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
        return $this->clientContextFactory->createRequest(
            $method,
            $uri,
            $protocolVersion,
            $headers,
            $body
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
        return $this->clientContextFactory->createResponse(
            $statusCode,
            $reasonPhrase,
            $protocolVersion,
            $headers,
            $body
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createUri($uri)
    {
        return $this->clientContextFactory->createUri($uri);
    }

    /**
     * {@inheritdoc}
     */
    public function createStream($body = null)
    {
        return $this->clientContextFactory->createStream($body);
    }
}
