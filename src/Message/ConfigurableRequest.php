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

use Http\Adapter\Message\ConfigurableMessage as ConfigurableMessageInterface;
use Http\Message\RequestDecorator;

/**
 * Allows to add configuration to a request
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
class ConfigurableRequest extends RequestDecorator implements ConfigurableMessageInterface
{
    use ConfigurableMessage;
}
