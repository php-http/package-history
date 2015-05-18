<?php

namespace spec\Http\Adapter\Common\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://php-http.org');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Common\Message\MessageFactory');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Adapter\Message\MessageFactory');
    }

    function it_has_a_base_uri()
    {
        $this->getBaseUri()->shouldHaveType('Psr\Http\Message\UriInterface');
        $this->hasBaseUri()->shouldReturn(true);
    }

    function it_accepts_a_base_uri()
    {
        $this->setBaseUri(null);
        $this->hasBaseUri()->shouldReturn(false);
    }

    function it_creates_a_request()
    {
        $this->createRequest('GET', '/')->shouldHaveType('Psr\Http\Message\RequestInterface');
    }

    function it_creates_a_response()
    {
        $this->createResponse()->shouldHaveType('Psr\Http\Message\ResponseInterface');
    }
}
