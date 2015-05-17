<?php

namespace spec\Http\Adapter\Core\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidRequestExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('invalid');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Exception\InvalidRequestException');
    }

    function it_is_thrown_when_a_request_is_invalid()
    {
        $this->getMessage()
            ->shouldReturn('The request must be a string, an array or implement "Psr\Http\Message\RequestInterface" ("string" given).');
    }
}
