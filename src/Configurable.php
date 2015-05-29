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
 * Allows to modify configuration
 *
 * @author Márk Sági-Kazár mark.sagikazar@gmail.com>
 */
interface Configurable extends HasConfiguration
{
    /**
     * Sets an option
     *
     * @param string $name
     * @param mixed  $option
     */
    public function setOption($name, $option);

    /**
     * Sets all options
     *
     * @param array $options
     */
    public function setOptions(array $options);
}
