<?php

namespace spec\Http\Common;

use Http\Common\Configurable;
use Http\Common\ConfigurableTemplate;
use PhpSpec\ObjectBehavior;

class ConfigurableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('spec\Http\Common\ConfigurableStub');
    }

    function it_is_configurable()
    {
        $this->shouldImplement('Http\Common\Configurable');
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

class ConfigurableStub implements Configurable
{
    use ConfigurableTemplate;
}
