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

use Http\Common\HasConfigurationTemplate;

/**
 * Should be used with Http\Common\Message\Configurable interface
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
trait ConfigurableTemplate
{
    use HasConfigurationTemplate;

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
