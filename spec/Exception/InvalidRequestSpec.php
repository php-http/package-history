<?php

namespace spec\Http\Adapter\Common\Exception;

use PhpSpec\ObjectBehavior;

class InvalidRequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('invalid');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Common\Exception\InvalidRequest');
    }

    function it_is_an_invalid_argument_exception()
    {
        $this->shouldHaveType('InvalidArgumentException');
    }

    function it_is_an_exception()
    {
        $this->shouldImplement('Http\Adapter\Exception');
    }

    function it_is_thrown_when_a_request_is_invalid()
    {
        $this->getMessage()
            ->shouldReturn('The request must be a string, an array or implement "Psr\Http\Message\RequestInterface" ("string" given).');
    }
}
