<?php

namespace spec\Http\Adapter\Core\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InternalRequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
    }
}
