<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter;

use Http\Adapter\Message\InternalRequestInterface;
use Http\Adapter\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
trait HttpAdapterTrait
{
    /**
     * {@inheritdoc}
     */
    public function get($uri, array $headers = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_GET, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function head($uri, array $headers = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_HEAD, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($uri, array $headers = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_TRACE, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_POST, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function put($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_PUT, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_PATCH, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_DELETE, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function options($uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->send($uri, InternalRequestInterface::METHOD_OPTIONS, $headers, $data, $files);
    }

    /**
     * {@inheritdoc}
     */
    public function send($uri, $method, array $headers = [], $data = [], array $files = [])
    {
        return $this->sendRequest($this->getConfiguration()->getMessageFactory()->createInternalRequest(
            $uri,
            $method,
            $this->getConfiguration()->getProtocolVersion(),
            $headers,
            $data,
            $files
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        if ($request instanceof InternalRequestInterface) {
            return $this->sendInternalRequest($request);
        }

        $protocolVersion = $this->getConfiguration()->getProtocolVersion();
        $this->getConfiguration()->setProtocolVersion($request->getProtocolVersion());

        $response = $this->send(
            $request->getUri(),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getBody()
        );

        $this->getConfiguration()->setProtocolVersion($protocolVersion);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequests(array $requests)
    {
        $responses = $exceptions = [];

        foreach ($requests as $index => &$request) {
            if (is_string($request)) {
                $request = array($request);
            }

            if (is_array($request)) {
                $request = call_user_func_array(
                    array($this->getConfiguration()->getMessageFactory(), 'createInternalRequest'),
                    $request
                );
            }

            if (!$request instanceof RequestInterface) {
                $exceptions[] = HttpAdapterException::requestIsNotValid($request);
                unset($requests[$index]);
            } elseif (!$request instanceof InternalRequestInterface) {
                $request = $this->getConfiguration()->getMessageFactory()->createInternalRequest(
                    $request->getUri(),
                    $request->getMethod(),
                    $request->getProtocolVersion(),
                    $request->getHeaders(),
                    $request->getBody()
                );
            }
        }

        $success = function (ResponseInterface $response) use (&$responses) {
            $responses[] = $response;
        };

        $error = function (HttpAdapterException $exception) use (&$exceptions) {
            $exceptions[] = $exception;
        };

        $this->sendInternalRequests($requests, $success, $error);

        if (!empty($exceptions)) {
            throw new MultiHttpAdapterException($exceptions, $responses);
        }

        return $responses;
    }

    /**
     * Sends an internal request
     *
     * @param InternalRequestInterface $internalRequest
     *
     * @return ResponseInterface
     *
     * @throws HttpAdapterException If an error occurred.
     */
    abstract protected function sendInternalRequest(InternalRequestInterface $internalRequest);

    /**
     * Sends internal requests
     *
     * @param InternalRequestInterface[] $internalRequests
     * @param callable                   $success
     * @param callable                   $error
     *
     * @throws MultiHttpAdapterException If an error occurred.
     *
     * @return array The responses.
     */
    protected function sendInternalRequests(array $internalRequests, $success, $error)
    {
        foreach ($internalRequests as $internalRequest) {
            try {
                $response = $this->sendInternalRequest($internalRequest);
                $response = $response->withParameter('request', $internalRequest);
                call_user_func($success, $response);
            } catch (HttpAdapterException $e) {
                $e->setRequest($internalRequest);
                $e->setResponse(isset($response) ? $response : null);
                call_user_func($error, $e);
            }
        }
    }
}
