<?php

namespace spec\Http\Adapter\Common\Exception;

use Http\Adapter\Exception\HttpAdapterException;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;

class MultiHttpAdapterExceptionSpec extends ObjectBehavior
{
    function let(HttpAdapterException $exception, ResponseInterface $response)
    {
        $this->beConstructedWith([$exception], [$response]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Common\Exception\MultiHttpAdapterException');
    }

    function it_is_a_multi_http_adapter_exception()
    {
        $this->shouldImplement('Http\Adapter\Exception\MultiHttpAdapterException');
    }

    function it_has_a_message()
    {
        $this->getMessage()
            ->shouldReturn('An error occurred when sending multiple requests.');
    }

    function it_has_exceptions(HttpAdapterException $exception)
    {
        $this->getExceptions()->shouldReturn([$exception]);
    }

    function it_checks_exceptions(HttpAdapterException $exception)
    {
        $this->hasException($exception);
        $this->hasExceptions()->shouldReturn(true);
    }

    function it_accepts_exceptions(HttpAdapterException $anotherException)
    {
        $this->setExceptions([$anotherException]);
        $this->getExceptions()->shouldReturn([$anotherException]);
    }

    function it_accepts_an_exception(HttpAdapterException $anotherException)
    {
        $this->addException($anotherException);
        $this->hasException($anotherException)->shouldReturn(true);
    }

    function it_accepts_multiple_exceptions(HttpAdapterException $anotherException)
    {
        $this->addExceptions([$anotherException]);
        $this->hasException($anotherException)->shouldReturn(true);
    }

    function it_removes_an_exception(HttpAdapterException $exception)
    {
        $this->removeException($exception);
        $this->hasExceptions()->shouldReturn(false);
    }

    function it_removes_exceptions(HttpAdapterException $exception)
    {
        $this->removeExceptions([$exception]);
        $this->hasExceptions()->shouldReturn(false);
    }

    function it_clears_exceptions()
    {
        $this->clearExceptions();
        $this->hasExceptions()->shouldReturn(false);
    }

    function it_has_responses(ResponseInterface $response)
    {
        $this->getResponses()->shouldReturn([$response]);
    }

    function it_checks_responses(ResponseInterface $response)
    {
        $this->hasResponse($response);
        $this->hasResponses()->shouldReturn(true);
    }

    function it_accepts_responses(ResponseInterface $anotherResponse)
    {
        $this->setResponses([$anotherResponse]);
        $this->getResponses()->shouldReturn([$anotherResponse]);
    }

    function it_accepts_an_response(ResponseInterface $anotherResponse)
    {
        $this->addResponse($anotherResponse);
        $this->hasResponse($anotherResponse)->shouldReturn(true);
    }

    function it_accepts_multiple_responses(ResponseInterface $anotherResponse)
    {
        $this->addResponses([$anotherResponse]);
        $this->hasResponse($anotherResponse)->shouldReturn(true);
    }

    function it_removes_an_response(ResponseInterface $response)
    {
        $this->removeResponse($response);
        $this->hasResponses()->shouldReturn(false);
    }

    function it_removes_responses(ResponseInterface $response)
    {
        $this->removeResponses([$response]);
        $this->hasResponses()->shouldReturn(false);
    }

    function it_clears_responses()
    {
        $this->clearResponses();
        $this->hasResponses()->shouldReturn(false);
    }
}
