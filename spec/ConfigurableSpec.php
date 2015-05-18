<?php

namespace spec\Http\Adapter\Common;

use Http\Adapter\Configurable as ConfigurableInterface;
use Http\Adapter\Common\Configurable as ConfigurableTrait;
use PhpSpec\ObjectBehavior;

class ConfigurableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Common\ConfigurableStub');
    }

    function it_is_configurable()
    {
        $this->shouldImplement('Http\Adapter\Configurable');
    }

    function it_accepts_an_option()
    {
        $this->setOption('option', 'value');
        $this->getOption('option')->shouldReturn('value');
    }

    function it_accepts_options()
    {
        $this->setOptions([
            'option' => 'value',
        ]);
    }
}

class ConfigurableStub implements ConfigurableInterface
{
    use ConfigurableTrait;
}
