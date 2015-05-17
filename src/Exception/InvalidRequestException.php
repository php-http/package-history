<?php

/*
 * This file is part of the Http Adapter Core package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core\Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class InvalidRequestException extends HttpAdapterException
{
    /**
     * @param mixed $invalidRequest
     */
    public function __construct($invalidRequest)
    {
        parent::__construct(sprintf(
            'The request must be a string, an array or implement "Psr\Http\Message\RequestInterface" ("%s" given).',
            is_object($invalidRequest) ? get_class($invalidRequest) : gettype($invalidRequest)
        ));
    }
}
