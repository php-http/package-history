<?php

namespace spec\Http\Common\Message;

use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;

class ConfigurableRequestSpec extends ObjectBehavior
{
    function let(RequestInterface $request)
    {
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Common\Message\ConfigurableRequest');
    }

    function it_is_a_request()
    {
        $this->shouldImplement('Psr\Http\Message\RequestInterface');
    }

    function it_is_a_configurable_message()
    {
        $this->shouldImplement('Http\Common\Message\Configurable');
    }
}
