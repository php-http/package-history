<?php

/*
 * This file is part of the Http Adapter Core package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core;

use Http\Adapter\HasConfiguration as HasConfigurationInterface;
use Http\Adapter\Message\InternalRequestInterface;
use Http\Adapter\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
trait HttpAdapter
{
    use PsrHttpAdapter;

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $headers = [], array $options = [])
    {
        return $this->send('GET', $uri, $headers, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uri, array $headers = [], array $options = [])
    {
        return $this->send('HEAD', $uri, $headers, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($uri, array $headers = [], array $options = [])
    {
        return $this->send('TRACE', $uri, $headers, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        return $this->send('POST', $uri, $headers, $data, $files, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        return $this->send('PUT', $uri, $headers, $data, $files, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        return $this->send('PATCH', $uri, $headers, $data, $files, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        return $this->send('DELETE', $uri, $headers, $data, $files, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function options($uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        return $this->send('OPTIONS', $uri, $headers, $data, $files, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function send($method, $uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        if ($data instanceof StreamInterface && !empty($files)) {
            throw new \InvalidArgumentException('A data instance of Psr\Http\Message\StreamInterface and $files parameters should not be passed together.');
        }

        $globalOptions = [];

        if ($this instanceof HasConfigurationInterface) {
            $globalOptions = $this->getOptions();
        }

        $options = array_merge($globalOptions, $options);

        $request = $this->getMessageFactory()->createInternalRequest(
            $method,
            $uri,
            isset($options['protocolVersion']) ? $options['protocolVersion'] : '1.1',
            $headers,
            $data,
            $files,
            [],
            $options
        );

        return $this->sendInternalRequest($request);
    }
}
