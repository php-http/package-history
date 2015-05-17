<?php

namespace spec\Http\Adapter\Core\Message;

use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurableRequestSpec extends ObjectBehavior
{
    function let(RequestInterface $request)
    {
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Message\ConfigurableRequest');
    }
}
