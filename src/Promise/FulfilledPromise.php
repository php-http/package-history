<?php

namespace Http\Client\Tools\Promise;

use Http\Client\Exception;
use Http\Client\Promise;
use Psr\Http\Message\ResponseInterface;

/**
 * A promise already fulfilled.
 *
 * @author Joel Wurtz <jwurtz@jolicode.com>
 */
final class FulfilledPromise implements Promise
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        try {
            return new self($onFulfilled($this->response));
        } catch (Exception $e) {
            return new RejectedPromise($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return Promise::FULFILLED;
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
    public function getException()
    {
        throw new \LogicException('Promise is fulfilled, no exception available');
    }

    /**
     * {@inheritdoc}
     */
    public function wait()
    {
    }
}
