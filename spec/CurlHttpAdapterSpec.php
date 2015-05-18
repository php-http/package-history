<?php

namespace spec\Http\Adapter\Core;

use Http\Adapter\Core\CurlHttpAdapter;
use Http\Adapter\Internal\Message\InternalRequest;
use Http\Adapter\Internal\Message\MessageFactory;
use PhpSpec\ObjectBehavior;

class CurlHttpAdapterSpec extends ObjectBehavior
{
    public function let(MessageFactory $messageFactory)
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Core\CurlHttpAdapterStub');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\CurlHttpAdapter');
    }

    function it_is_a_core_http_adapter()
    {
        $this->shouldHaveType('Http\Adapter\Core\CoreHttpAdapter');
    }
}

class CurlHttpAdapterStub extends CurlHttpAdapter
{
    public function getName()
    {
        return 'curl';
    }

    public function sendInternalRequest(InternalRequest $internalRequest)
    {
        // noop
    }
}
