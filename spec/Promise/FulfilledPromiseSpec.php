<?php

namespace spec\Http\Client\Tools\Promise;

use Http\Client\Exception;
use Http\Client\Exception\TransferException;
use Http\Client\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FulfilledPromiseSpec extends ObjectBehavior
{
    function let(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
    }

    function it_is_initializable(ResponseInterface $response)
    {
        $this->shouldHaveType('Http\Client\Tools\Promise\FulfilledPromise');
    }

    function it_is_a_promise()
    {
        $this->shouldImplement('Http\Client\Promise');
    }

    function it_returns_a_fulfilled_promise(ResponseInterface $response)
    {
        $promise = $this->then(function (ResponseInterface $responseReceived) use ($response) {
            if (Argument::is($responseReceived)->scoreArgument($response->getWrappedObject())) {
                return $response->getWrappedObject();
            }
        });

        $promise->shouldHaveType('Http\Client\Promise');
        $promise->shouldHaveType('Http\Client\Tools\Promise\FulfilledPromise');
        $promise->getState()->shouldReturn(Promise::FULFILLED);
        $promise->getResponse()->shouldReturn($response);
    }

    function it_returns_a_rejected_promise(RequestInterface $request, ResponseInterface $response)
    {
        $exception = new TransferException();

        $promise = $this->then(function (ResponseInterface $responseReceived) use ($response, $exception) {
            if (Argument::is($responseReceived)->scoreArgument($response->getWrappedObject())) {
                throw $exception;
            }
        });

        $promise->shouldHaveType('Http\Client\Promise');
        $promise->shouldHaveType('Http\Client\Tools\Promise\RejectedPromise');
        $promise->getState()->shouldReturn(Promise::REJECTED);
        $promise->getException()->shouldReturn($exception);
    }

    function it_is_in_fulfilled_state()
    {
        $this->getState()->shouldReturn(Promise::FULFILLED);
    }

    function it_has_a_response(ResponseInterface $response)
    {
        $this->getResponse()->shouldReturn($response);
    }

    function it_throws_an_exception_for_reason()
    {
        $this->shouldThrow('LogicException')->duringGetException();
    }
}
