<?php

namespace spec\Http\Adapter\Message;

use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;

class InternalMessageFactorySpec extends ObjectBehavior
{
    function let(MessageFactory $messageFactory)
    {
        $this->beConstructedWith($messageFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Message\InternalMessageFactory');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Message\MessageFactory');
    }

    function it_is_an_internal_message_factory()
    {
        $this->shouldImplement('Http\Client\Message\InternalMessageFactory');
    }

    function it_creates_a_request(MessageFactory $messageFactory, RequestInterface $request)
    {
        $messageFactory->createRequest('GET', '/', '1.1', [], null)->willReturn($request);

        $this->createRequest('GET', '/')->shouldReturn($request);
    }

    function it_creates_a_response(MessageFactory $messageFactory, ResponseInterface $response)
    {
        $messageFactory->createResponse(200, null, '1.1', [], null)->willReturn($response);

        $this->createResponse()->shouldReturn($response);
    }

    function it_creates_an_internal_request(MessageFactory $messageFactory, RequestInterface $request)
    {
        $messageFactory->createRequest('GET', '/', '1.1', [], null)->willReturn($request);

        $internalRequest = $this->createInternalRequest('GET', '/', '1.1', [], null);

        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
        $internalRequest->shouldHaveType('Http\Adapter\Message\InternalRequest');
    }
}
