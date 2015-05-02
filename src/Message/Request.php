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

use Phly\Http\Request as PhlyRequest;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Request extends PhlyRequest implements RequestInterface
{
    use MessageTrait;

    /**
     * @param null|string|UriInterface        $uri
     * @param null|string                     $method
     * @param string|resource|StreamInterface $body
     * @param string[]                        $headers
     * @param array                           $parameters
     */
    public function __construct(
        $uri = null,
        $method = null,
        $body = 'php://memory',
        array $headers = [],
        array $parameters = []
    ) {
        parent::__construct($uri, $method, $body, $headers);

        $this->parameters = $parameters;
    }
}
