<?php

/*
 * This file is part of the Http Client package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Client\Message;

use Http\Message\MessageFactory;
use Psr\Http\Message\UriInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
interface InternalMessageFactory extends MessageFactory
{
    /**
     * Creates an internal request
     *
     * @param string              $method
     * @param string|UriInterface $uri
     * @param string              $protocolVersion
     * @param string[]            $headers
     * @param array|string        $data
     * @param array               $files
     * @param array               $parameters
     *
     * @return InternalRequest
     */
    public function createInternalRequest(
        $method,
        $uri,
        $protocolVersion = '1.1',
        array $headers = [],
        $data = [],
        array $files = [],
        array $parameters = []
    );
}
