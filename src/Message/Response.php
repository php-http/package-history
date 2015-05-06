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

use Phly\Http\Response as PhlyResponse;
use Psr\Http\Message\StreamInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Response extends PhlyResponse implements ResponseInterface
{
    use MessageTrait;

    /**
     * @param integer                         $status
     * @param string[]                        $headers
     * @param string|resource|StreamInterface $body
     * @param array                           $parameters
     */
    public function __construct(
        $status = 200,
        array $headers = [],
        $body = 'php://memory',
        array $parameters = []
    ) {
        parent::__construct($body, $status, $headers);

        $this->parameters = $parameters;
    }
}
