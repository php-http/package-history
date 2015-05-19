<?php

namespace spec\Http\Adapter\Core\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Message\MessageFactory');
    }

    function it_is_a_message_factory()
    {
        $this->shouldImplement('Http\Adapter\Internal\Message\MessageFactory');
    }

    function it_creates_an_internal_request()
    {
        $this->createInternalRequest('GET', '/', '1.1', [], 'body')->shouldHaveType('Http\Adapter\Internal\Message\InternalRequest');
    }
}
