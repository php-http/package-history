<?php

/*
 * This file is part of the Http Adapter Client package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Message;

/**
 * Should be used with Http\Client\Message\Parameterable interface
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait ParameterableTemplate
{
    /**
     * @var array
     */
    private $parameters = [];

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        return $this->hasParameter($name) ? $this->parameters[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        return isset($this->parameters[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function withParameter($name, $value)
    {
        $new = clone $this;
        $new->parameters[$name] = $value;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedParameter($name, $value)
    {
        $new = clone $this;
        $new->parameters[$name] = $new->hasParameter($name)
            ? array_merge((array) $new->parameters[$name], (array) $value)
            : $value;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutParameter($name)
    {
        $new = clone $this;
        unset($new->parameters[$name]);

        return $new;
    }
}
