<?php

namespace spec\Http\Adapter\Core\Message;

use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParameterableResponseSpec extends ObjectBehavior
{
    function let(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Message\ParameterableResponse');
    }

    function it_is_a_parameterable_message(ResponseInterface $response)
    {
        $this->shouldImplement('Http\Adapter\Message\ParameterableMessage');

        $this->getMessage()->shouldReturn($response);
        $this->hasParameter('param')->shouldReturn(false);
        $this->hasParameters()->shouldReturn(false);
        $message = $this->withParameter('param', 'value');
        $message->shouldHaveType('Http\Adapter\Core\Message\ParameterableResponse');
        $message->getParameter('param')->shouldReturn('value');
        $message->getParameters()->shouldReturn(['param' => 'value']);
        $message->hasParameter('param')->shouldReturn(true);
        $message->hasParameters()->shouldReturn(true);
        $message = $message->withAddedParameter('param', 'value2');
        $message->shouldHaveType('Http\Adapter\Core\Message\ParameterableResponse');
        $message->getParameter('param')->shouldReturn(['value', 'value2']);
        $message->getParameters()->shouldReturn(['param' => ['value', 'value2']]);
        $message = $message->withoutParameter('param');
        $message->shouldHaveType('Http\Adapter\Core\Message\ParameterableResponse');
        $message->hasParameter('param')->shouldReturn(false);
        $message->hasParameters()->shouldReturn(false);
    }
}
