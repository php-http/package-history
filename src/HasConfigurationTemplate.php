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
 * Should be used with Http\Common\HasConfiguration interface
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
trait HasConfigurationTemplate
{
    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasOptions()
    {
        return !empty($this->options);
    }
}
