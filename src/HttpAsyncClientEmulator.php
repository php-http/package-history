<?php

namespace Http\Client\Tools;

use Http\Client\Exception;
use Http\Client\Tools\Promise as P;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Emulates an HTTP Async Client in an HTTP Client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait HttpAsyncClientEmulator
{
    /**
     * Sends a PSR-7 request.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws Exception
     */
    abstract public function sendRequest(RequestInterface $request);

    /**
     * Sends a PSR-7 request in an asynchronous way.
     *
     * @param RequestInterface $request
     *
     * @return Promise
     */
    public function sendAsyncRequest(RequestInterface $request)
    {
        try {
            return new P\FulfilledPromise($this->sendRequest($request));
        } catch (Exception $e) {
            return new P\RejectedPromise($e);
        }
    }
}
