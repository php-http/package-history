<?php

namespace spec\Http\Adapter\Common\Message;

use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;

class MessageFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Common\Message\MessageFactory');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Message\ClientContextFactory');
    }

    function it_creates_a_request()
    {
        $this->createRequest('GET', '/')->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_response()
    {
        $this->createResponse()->shouldHaveType('Psr\Http\Message\ResponseInterface');
    }

    function it_creates_an_empty_stream()
    {
        $this->createStream()->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_a_string_stream()
    {
        $this->createStream('Body')->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_a_resource_stream()
    {
        $resource = tmpfile();
        $this->createStream($resource)->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_a_stream_stream(StreamInterface $stream)
    {
        $stream->rewind()->shouldBeCalled();

        $this->createStream($stream)->shouldHaveType('Psr\Http\Message\StreamInterface');
    }

    function it_creates_an_uri()
    {
        $this->createUri('http://php-http.org')->shouldHaveType('Psr\Http\Message\UriInterface');
    }
}
