<?php

/*
 * This file is part of the Http Adapter Client package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Message;

use Http\Client\Message\InternalMessageFactory as InternalMessageFactoryInterface;
use Http\Message\MessageFactory;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class InternalMessageFactory implements InternalMessageFactoryInterface
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

    /**
     * {@inheritdoc}
     */
    public function createInternalRequest(
        $method,
        $uri,
        $protocolVersion = '1.1',
        array $headers = [],
        $data = [],
        array $files = [],
        array $parameters = []
    ) {
        $body = null;

        if (!is_array($data)) {
            $body = $data;
            $data = $files = [];
        }

        $request = $this->createRequest($method, $uri, $protocolVersion, $headers, $body);

        return new InternalRequest($request, $data, $files, $parameters);
    }
}
