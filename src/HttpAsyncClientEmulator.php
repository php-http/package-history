<?php

namespace Http\Client\Tools;

use Http\Client\Exception;
use Http\Client\Tools\Promise as P;
use Psr\Http\Message\RequestInterface;

/**
 * Emulates an HTTP Async Client in an HTTP Client.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait HttpAsyncClientEmulator
{
    /**
     * {@inheritdoc}
     *
     * @see HttpClient::sendRequest
     */
    abstract public function sendRequest(RequestInterface $request);

    /**
     * {@inheritdoc}
     *
     * @see HttpAsyncClient::sendAsyncRequest
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
