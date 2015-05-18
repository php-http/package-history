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

use Http\Adapter\HasConfiguration;
use Http\Adapter\Common\ConfigurableHttpAdapter;
use Psr\Http\Message\StreamInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
trait HttpAdapter
{
    use ConfigurableHttpAdapter;
    use PsrHttpAdapter;

    /**
     * {@inheritdoc}
     */
    public function send($method, $uri, array $headers = [], $data = [], array $files = [], array $options = [])
    {
        if ($data instanceof StreamInterface && !empty($files)) {
            throw new \InvalidArgumentException('A data instance of Psr\Http\Message\StreamInterface and $files parameters should not be passed together.');
        }

        $globalOptions = [];

        if ($this instanceof HasConfiguration) {
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
