<?php

namespace spec\Http\Common\Message;

use Http\Common\Message\Configurable;
use Http\Common\Message\ConfigurableTemplate;
use PhpSpec\ObjectBehavior;

class ConfigurableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Common\Message\ConfigurableStub');
    }

    function it_is_configurable()
    {
        $this->shouldImplement('Http\Common\Message\Configurable');
    }

    function it_accepts_an_option()
    {
        $configurable = $this->withOption('option', 'value');
        $configurable->shouldHaveType('Http\Common\Message\Configurable');
        $configurable->getOption('option')->shouldReturn('value');
    }

    function it_removes_an_option()
    {
        $configurable = $this->withOption('option', 'value');
        $configurable->hasOption('option')->shouldReturn(true);

        $configurable = $configurable->withoutOption('option');
        $configurable->shouldHaveType('Http\Common\Message\Configurable');
        $configurable->hasOption('option')->shouldReturn(false);
    }
}

class ConfigurableStub implements Configurable
{
    use ConfigurableTemplate;
}
