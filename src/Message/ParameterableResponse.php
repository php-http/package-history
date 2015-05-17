<?php

/*
 * This file is part of the Http Adapter Core package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core\Message;

use Http\Adapter\Message\ParameterableMessage as ParameterableMessageInterface;
use Http\Message\ResponseDecorator;

/**
 * Allows to add parameters to a response
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
class ParameterableResponse extends ResponseDecorator implements ParameterableMessageInterface
{
    use ParameterableMessage;
}
