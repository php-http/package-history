<?php

namespace spec\Http\Adapter\Core\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MultiHttpAdapterExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Exception\MultiHttpAdapterException');
    }
}
