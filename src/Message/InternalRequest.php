<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Message;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class InternalRequest extends Request implements InternalRequestInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $files = [];

    /**
     * @param null|string                     $method
     * @param null|string|UriInterface        $uri
     * @param string[]                        $headers
     * @param string|resource|StreamInterface $body
     * @param array                           $data
     * @param array                           $files
     * @param array                           $parameters
     */
    public function __construct(
        $method = null,
        $uri = null,
        array $headers = [],
        $body = 'php://memory',
        array $data = [],
        array $files = [],
        array $parameters = []
    ) {
        parent::__construct($method, $uri, $headers, $body, $parameters);

        $this->data = $data;
        $this->files = $files;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($name)
    {
        return $this->hasData($name) ? $this->data[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function hasData($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAnyData()
    {
        return !empty($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function withData($name, $value)
    {
        $new = clone $this;
        $new->data[$name] = $value;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedData($name, $value)
    {
        $new = clone $this;
        $new->data[$name] = $new->hasData($name)
            ? array_merge((array) $new->data[$name], (array) $value)
            : $value;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutData($name)
    {
        $new = clone $this;
        unset($new->data[$name]);

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile($name)
    {
        return $this->hasFile($name) ? $this->files[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile($name)
    {
        return isset($this->files[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function hasFiles()
    {
        return !empty($this->files);
    }

    /**
     * {@inheritdoc}
     */
    public function withFile($name, $file)
    {
        $new = clone $this;
        $new->files[$name] = $file;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedFile($name, $file)
    {
        $new = clone $this;
        $new->files[$name] = $new->hasFile($name)
            ? array_merge((array) $new->files[$name], (array) $file)
            : $file;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutFile($name)
    {
        $new = clone $this;
        unset($new->files[$name]);

        return $new;
    }
}
