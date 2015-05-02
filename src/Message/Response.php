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
     * @param string|resource|StreamInterface $body
     * @param integer                         $status
     * @param string[]                        $headers
     * @param array                           $parameters
     */
    public function __construct(
        $body = 'php://memory',
        $status = 200,
        array $headers = [],
        array $parameters = []
    ) {
        parent::__construct($body, $status, $headers);

        $this->parameters = $parameters;
    }
}
