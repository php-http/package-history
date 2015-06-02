<?php

namespace spec\Http\Adapter\Message;

use Http\Client\Message\Parameterable;
use Http\Adapter\Message\ParameterableTemplate;
use PhpSpec\ObjectBehavior;

class ParameterableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Message\ParameterableStub');
    }

    function it_is_parameterable()
    {
        $this->shouldImplement('Http\Client\Message\Parameterable');
    }

    function it_has_a_parameter()
    {
        $this->getParameter('parameter1')->shouldReturn('value1');
        $this->hasParameter('parameter1')->shouldReturn(true);
        $this->hasParameter('parameter3')->shouldReturn(false);
    }

    function it_has_parameters()
    {
        $this->getParameters()->shouldReturn([
            'parameter1' => 'value1',
            'parameter2' => 'value2',
        ]);
        $this->hasParameters()->shouldReturn(true);
    }

    function it_accepts_a_parameter()
    {
        $parameterable = $this->withParameter('parameter', 'value');
        $parameterable->shouldHaveType('Http\Client\Message\Parameterable');
        $parameterable->getParameter('parameter')->shouldReturn('value');
    }

    function it_adds_a_parameter()
    {
        $parameterable = $this->withParameter('parameter', 'value1');
        $parameterable = $parameterable->withAddedParameter('parameter', 'value2');
        $parameterable->shouldHaveType('Http\Client\Message\Parameterable');
        $parameterable->getParameter('parameter')->shouldReturn(['value1', 'value2']);
    }

    function it_removes_a_parameter()
    {
        $parameterable = $this->withParameter('parameter', 'value');
        $parameterable->hasParameter('parameter')->shouldReturn(true);

        $parameterable = $parameterable->withoutParameter('parameter');
        $parameterable->shouldHaveType('Http\Client\Message\Parameterable');
        $parameterable->hasParameter('parameter')->shouldReturn(false);
    }
}

class ParameterableStub implements Parameterable
{
    use ParameterableTemplate;

    public function __construct()
    {
        $this->parameters = [
            'parameter1' => 'value1',
            'parameter2' => 'value2',
        ];
    }
}
