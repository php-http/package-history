<?php

namespace spec\Http\Common\Message\MessageFactory;

use Http\Common\Message\MessageFactory\ClientContextFactoryDecorator;
use Http\Message\ClientContextFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use PhpSpec\ObjectBehavior;

class ClientContextFactoryDecoratorSpec extends ObjectBehavior
{
    function let(ClientContextFactory $clientContextFactory)
    {
        $this->beAnInstanceOf('spec\Http\Common\Message\MessageFactory\ClientContextFactoryDecoratorStub', [$clientContextFactory]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Common\Message\MessageFactory\ClientContextFactoryDecorator');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Message\ClientContextFactory');
    }

    function it_creates_a_request(ClientContextFactory $clientContextFactory, RequestInterface $request)
    {
        $clientContextFactory->createRequest('GET', '/', '1.1', [], null)->willReturn($request);

        $this->createRequest('GET', '/')->shouldReturn($request);
    }

    function it_creates_a_response(ClientContextFactory $clientContextFactory, ResponseInterface $response)
    {
        $clientContextFactory->createResponse(200, null, '1.1', [], null)->willReturn($response);

        $this->createResponse()->shouldReturn($response);
    }

    function it_creates_an_empty_stream(ClientContextFactory $clientContextFactory, StreamInterface $stream)
    {
        $clientContextFactory->createStream(null)->willReturn($stream);

        $this->createStream()->shouldReturn($stream);
    }

    function it_creates_a_stream_stream(ClientContextFactory $clientContextFactory, StreamInterface $stream)
    {
        $clientContextFactory->createStream($stream)->will(function($args) {
            $args[0]->rewind();

            return $args[0];
        });

        $stream->rewind()->shouldBeCalled();

        $this->createStream($stream)->shouldReturn($stream);
    }

    function it_creates_an_uri(ClientContextFactory $clientContextFactory, UriInterface $uri)
    {
        $clientContextFactory->createUri('http://php-http.org')->willReturn($uri);

        $this->createUri('http://php-http.org')->shouldReturn($uri);
    }
}

class ClientContextFactoryDecoratorStub extends ClientContextFactoryDecorator
{

}
