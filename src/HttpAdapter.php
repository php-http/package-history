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
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait HttpAdapter
{
    /**
     * {@inheritdoc}
     */
    public function get($uri, array $headers = [])
    {
        return $this->send('GET', $uri, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uri, array $headers = [])
    {
        return $this->send('HEAD', $uri, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($uri, array $headers = [])
    {
        return $this->send('TRACE', $uri, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send('POST', $uri, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send('PUT', $uri, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send('PATCH', $uri, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send('DELETE', $uri, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function options($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send('OPTIONS', $uri, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function send($method, $uri, array $headers = [], $data = [], array $files = []);
}
