<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common;

/**
 * Should be used with Http\Adapter\Configurable interface
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
trait Configurable
{
    use HasConfiguration;

    /**
     * {@inheritdoc}
     */
    public function setOption($name, $option)
    {
        $this->options[$name] = $option;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}
