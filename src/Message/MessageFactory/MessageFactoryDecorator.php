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

use Http\Message\MessageFactory;

/**
 * Can be used with custom logic
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
abstract class MessageFactoryDecorator implements MessageFactory
{
    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @param MessageFactory $messageFactory
     */
    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
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
        return $this->messageFactory->createRequest(
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
        return $this->messageFactory->createResponse(
            $statusCode,
            $reasonPhrase,
            $protocolVersion,
            $headers,
            $body
        );
    }
}
