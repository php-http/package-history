<?php

/*
 * This file is part of the Http Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Common;

/**
 * Should be used with Http\Common\Configurable interface
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
trait ConfigurableTemplate
{
    use HasConfigurationTemplate;

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
