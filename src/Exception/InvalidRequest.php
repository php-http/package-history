<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common\Exception;

use Http\Adapter\Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class InvalidRequest extends \InvalidArgumentException implements Exception
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
