<?php

namespace spec\Http\Common;

use Http\Common\HasConfiguration;
use Http\Common\HasConfigurationTemplate;
use PhpSpec\ObjectBehavior;

class HasConfigurationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Common\HasConfigurationStub');
    }

    function it_has_configuration()
    {
        $this->shouldImplement('Http\Common\HasConfiguration');
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

class HasConfigurationStub implements HasConfiguration
{
    use HasConfigurationTemplate;

    public function __construct()
    {
        $this->options = [
            'option1' => 'value1',
            'option2' => 'value2',
        ];
    }
}
