<?php

namespace spec\Http\Common\Message\MessageFactory;

use Http\Common\Message\MessageFactory\MessageFactoryDecorator;
use Http\Message\MessageFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use PhpSpec\ObjectBehavior;

class MessageFactoryDecoratorSpec extends ObjectBehavior
{
    function let(MessageFactory $messageFactory)
    {
        $this->beAnInstanceOf('spec\Http\Common\Message\MessageFactory\MessageFactoryDecoratorStub', [$messageFactory]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Common\Message\MessageFactory\MessageFactoryDecorator');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Message\MessageFactory');
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
}

class MessageFactoryDecoratorStub extends MessageFactoryDecorator
{

}
