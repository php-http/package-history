<?php

namespace spec\Http\Adapter\Common\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;

class HttpAdapterExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Common\Exception\HttpAdapterException');
    }

    function it_is_an_http_adapter_exception()
    {
        $this->shouldImplement('Http\Adapter\Exception\HttpAdapterException');
    }

    function it_does_not_have_a_request_by_default()
    {
        $this->getRequest()->shouldReturn(null);
        $this->hasRequest()->shouldReturn(false);
    }

    function it_accepts_a_request(RequestInterface $request)
    {
        $this->setRequest($request);
        $this->getRequest()->shouldReturn($request);
        $this->hasRequest()->shouldReturn(true);

        $this->setRequest(null);
        $this->getRequest()->shouldReturn(null);
        $this->hasRequest()->shouldReturn(false);
    }

    function it_does_not_have_a_response_by_default()
    {
        $this->getRequest()->shouldReturn(null);
        $this->hasRequest()->shouldReturn(false);
    }

    function it_accepts_a_response(ResponseInterface $response)
    {
        $this->setResponse($response);
        $this->getResponse()->shouldReturn($response);
        $this->hasResponse()->shouldReturn(true);

        $this->setResponse(null);
        $this->getResponse()->shouldReturn(null);
        $this->hasResponse()->shouldReturn(false);
    }
}
