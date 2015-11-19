<?php

namespace Http\Client\Tools;

use Http\Client\Exception;
use Http\Client\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Emulates an HTTP Client in an HTTP Async Client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait HttpClientEmulator
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
    public function sendRequest(RequestInterface $request)
    {
        $promise = $this->sendAsyncRequest($request);
        $promise->wait();

        if ($promise->getState() == Promise::REJECTED) {
            throw $promise->getException();
        }

        return $promise->getResponse();
    }

    /**
     * Sends a PSR-7 request in an asynchronous way.
     *
     * @param RequestInterface $request
     *
     * @return Promise
     */
    abstract public function sendAsyncRequest(RequestInterface $request);
}
