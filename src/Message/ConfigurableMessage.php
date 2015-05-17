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

use Http\Adapter\Core\HasConfiguration;

/**
 * Should be used with Http\Adapter\Message\ConfigurableMessage interface
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
trait ConfigurableMessage
{
    use HasConfiguration;

    /**
     * {@inheritdoc}
     */
    public function withOption($name, $option)
    {
        $new = clone $this;
        $new->options[$name] = $options;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutOption($name)
    {
        $new = clone $this;

        if (isset($new->options[$name])) {
            unset($new->options[$name]);
        }

        return $new;
    }
}
