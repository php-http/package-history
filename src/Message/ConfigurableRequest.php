<?php

/*
 * This file is part of the Http Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Common\Message;

use Http\Message\RequestDecorator;
use Psr\Http\Message\RequestInterface;

/**
 * Allows to add configuration to a request
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
class ConfigurableRequest implements Configurable, RequestInterface
{
    use ConfigurableTemplate, RequestDecorator;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->message = $request;
    }
}
