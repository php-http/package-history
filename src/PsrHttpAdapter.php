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

use Http\Adapter\Exception\HttpAdapterException;
use Http\Adapter\Exception\MultiHttpAdapterException;
use Http\Adapter\HasConfiguration as HasConfigurationInterface;
use Http\Adapter\Message\InternalRequest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * The using class should implement Http\Adapter\Message\MessageFactoryAware
 *
 * @author Márk Sági-Kazár <geloen.eric@gmail.com>
 */
trait PsrHttpAdapter
{
    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        if (!$request instanceof InternalRequest) {
            $request = $this->createRequestInternalFromPsr($request);
        }

        return $this->sendInternalRequest($request);
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
                    array($this->getMessageFactory(), 'createInternalRequest'),
                    $request
                );
            }

            if (!$request instanceof RequestInterface) {
                $exceptions[] = new Exception\InvalidRequestException($request);
                unset($requests[$index]);
            } elseif (!$request instanceof InternalRequest) {
                $request = $this->createRequestInternalFromPsr($request);
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
            throw new Exception\MultiHttpAdapterException($exceptions, $responses);
        }

        return $responses;
    }

    /**
     * Sends an internal request
     *
     * @param InternalRequest $internalRequest
     *
     * @return ResponseInterface
     *
     * @throws HttpAdapterException
     */
    abstract protected function sendInternalRequest(InternalRequest $internalRequest);

    /**
     * Sends internal requests
     *
     * @param InternalRequest[] $internalRequests
     * @param callable          $success
     * @param callable          $error
     *
     * @return array
     *
     * @throws MultiHttpAdapterException
     */
    protected function sendInternalRequests(array $internalRequests, callable $success, callable $error)
    {
        foreach ($internalRequests as $internalRequest) {
            try {
                $response = $this->sendInternalRequest($internalRequest);

                // TODO: Remove this
                $response = new Message\ParameterableResponse($response);
                $response = $response->withParameter('request', $internalRequest);

                call_user_func($success, $response);
            } catch (HttpAdapterException $e) {
                $e->setRequest($internalRequest);
                $e->setResponse(isset($response) ? $response : null);
                call_user_func($error, $e);
            }
        }
    }

    /**
     * @param RequestInterface $request
     *
     * @return InternalRequest
     */
    private function createRequestInternalFromPsr(RequestInterface $request)
    {
        $globalOptions = [];
        $options = [];

        if ($this instanceof HasConfigurationInterface) {
            $globalOptions = $this->getOptions();
        }

        if ($request instanceof HasConfigurationInterface) {
            $options = $request->getOptions();
        }

        $options = array_merge($globalOptions, $options);

        return $this->getMessageFactory()->createInternalRequest(
            $request->getMethod(),
            $request->getUri(),
            $request->getProtocolVersion(),
            $request->getHeaders(),
            $request->getBody(),
            [],
            [],
            $options
        );
    }
}
