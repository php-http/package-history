<?php

namespace spec\Http\Adapter\Common;

use Http\Adapter\HasConfiguration as HasConfigurationInterface;
use Http\Adapter\Common\HasConfiguration as HasConfigurationTrait;
use PhpSpec\ObjectBehavior;

class HasConfigurationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Common\HasConfigurationStub');
    }

    function it_has_configuration()
    {
        $this->shouldImplement('Http\Adapter\HasConfiguration');
    }

    function it_has_an_option()
    {
        $this->getOption('option1')->shouldReturn('value1');
        $this->hasOption('option1')->shouldReturn(true);
        $this->hasOption('option3')->shouldReturn(false);
    }

    function it_has_options()
    {
        $this->getOptions()->shouldReturn([
            'option1' => 'value1',
            'option2' => 'value2',
        ]);
        $this->hasOptions()->shouldReturn(true);
    }
}

class HasConfigurationStub implements HasConfigurationInterface
{
    use HasConfigurationTrait;

    public function __construct()
    {
        $this->options = [
            'option1' => 'value1',
            'option2' => 'value2',
        ];
    }
}
