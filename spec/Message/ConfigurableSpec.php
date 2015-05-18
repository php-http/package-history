<?php

namespace spec\Http\Adapter\Common\Message;

use Http\Adapter\Message\Configurable as ConfigurableInterface;
use Http\Adapter\Common\Message\Configurable as ConfigurableTrait;
use PhpSpec\ObjectBehavior;

class ConfigurableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Common\Message\ConfigurableStub');
    }

    function it_is_configurable()
    {
        $this->shouldImplement('Http\Adapter\Message\Configurable');
    }

    function it_accepts_an_option()
    {
        $configurable = $this->withOption('option', 'value');
        $configurable->shouldHaveType('Http\Adapter\Message\Configurable');
        $configurable->getOption('option')->shouldReturn('value');
    }

    function it_removes_an_option()
    {
        $configurable = $this->withOption('option', 'value');
        $configurable->hasOption('option')->shouldReturn(true);

        $configurable = $configurable->withoutOption('option');
        $configurable->shouldHaveType('Http\Adapter\Message\Configurable');
        $configurable->hasOption('option')->shouldReturn(false);
    }
}

class ConfigurableStub implements ConfigurableInterface
{
    use ConfigurableTrait;
}
