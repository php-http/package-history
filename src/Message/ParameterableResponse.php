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

use Http\Client\Message\Parameterable;
use Http\Message\ResponseDecorator;
use Psr\Http\Message\ResponseInterface;

/**
 * Allows to add parameters to a response
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
class ParameterableResponse implements Parameterable, ResponseInterface
{
    use ParameterableTemplate, ResponseDecorator;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->message = $response;
    }
}
