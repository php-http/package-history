<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common\Message;

use Http\Adapter\Common\HasConfiguration;

/**
 * Should be used with Http\Adapter\Message\Configurable interface
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
trait Configurable
{
    use HasConfiguration;

    /**
     * {@inheritdoc}
     */
    public function withOption($name, $option)
    {
        $new = clone $this;
        $new->options[$name] = $option;

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
