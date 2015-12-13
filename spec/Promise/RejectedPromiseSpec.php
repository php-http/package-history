<?php

namespace spec\Http\Client\Tools\Promise;

use Http\Client\Exception\TransferException;
use Http\Client\Exception;
use Http\Promise\Promise;
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
        $this->shouldImplement('Http\Promise\Promise');
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

        $promise->shouldHaveType('Http\Promise\Promise');
        $promise->shouldHaveType('Http\Client\Tools\Promise\FulfilledPromise');
        $promise->getState()->shouldReturn(Promise::FULFILLED);
        $promise->wait()->shouldReturn($response);
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

        $promise->shouldHaveType('Http\Promise\Promise');
        $promise->shouldHaveType('Http\Client\Tools\Promise\RejectedPromise');
        $promise->getState()->shouldReturn(Promise::REJECTED);
        $promise->shouldThrow($exception)->duringWait();
    }

    function it_is_in_rejected_state()
    {
        $this->getState()->shouldReturn(Promise::REJECTED);
    }

    function it_returns_an_exception()
    {
        $exception = new TransferException();

        $this->beConstructedWith($exception);
        $this->shouldThrow($exception)->duringWait();
    }
}
