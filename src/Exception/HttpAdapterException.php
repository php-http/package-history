<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common\Exception;

use Http\Adapter\Exception\HttpAdapterException as HttpAdapterExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class HttpAdapterException extends \Exception implements HttpAdapterExceptionInterface
{
    /**
     * @var RequestInterface|null
     */
    private $request;

    /**
     * @var ResponseInterface|null
     */
    private $response;

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequest()
    {
        return isset($this->request);
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest(RequestInterface $request = null)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function hasResponse()
    {
        return isset($this->response);
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(ResponseInterface $response = null)
    {
        $this->response = $response;
    }
}
