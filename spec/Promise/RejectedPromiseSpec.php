<?php

namespace spec\Http\Client\Tools\Promise;

use Http\Client\Exception\TransferException;
use Http\Client\Exception;
use Http\Client\Promise;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RejectedPromiseSpec extends ObjectBehavior
{
    function let(Exception $exception)
    {
        $this->beConstructedWith($exception);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Client\Tools\Promise\RejectedPromise');
    }

    function it_is_a_promise()
    {
        $this->shouldImplement('Http\Client\Promise');
    }

    function it_returns_a_fulfilled_promise(ResponseInterface $response)
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);

        $promise = $this->then(null, function (Exception $exceptionReceived) use($exception, $response) {
            if (Argument::is($exceptionReceived)->scoreArgument($exception)) {
                return $response->getWrappedObject();
            }
        });

        $promise->shouldHaveType('Http\Client\Promise');
        $promise->shouldHaveType('Http\Client\Tools\Promise\FulfilledPromise');
        $promise->getState()->shouldReturn(Promise::FULFILLED);
        $promise->getResponse()->shouldReturn($response);
    }

    function it_returns_a_rejected_promise()
    {
        $exception = new TransferException();
        $this->beConstructedWith($exception);

        $promise = $this->then(null, function (Exception $exceptionReceived) use($exception) {
            if (Argument::is($exceptionReceived)->scoreArgument($exception)) {
                throw $exception;
            }
        });

        $promise->shouldHaveType('Http\Client\Promise');
        $promise->shouldHaveType('Http\Client\Tools\Promise\RejectedPromise');
        $promise->getState()->shouldReturn(Promise::REJECTED);
        $promise->getException()->shouldReturn($exception);
    }

    function it_is_in_rejected_state()
    {
        $this->getState()->shouldReturn(Promise::REJECTED);
    }

    function it_returns_am_exception(Exception $exception)
    {
        $this->getException()->shouldReturn($exception);
    }

    function it_throws_an_exception_for_response()
    {
        $this->shouldThrow('LogicException')->duringGetResponse();
    }
}
