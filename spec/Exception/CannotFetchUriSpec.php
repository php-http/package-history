<?php

namespace spec\Http\Adapter\Common\Exception;

use PhpSpec\ObjectBehavior;

class CannotFetchUriSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('/', 'common', new \Exception('Request failed'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Common\Exception\CannotFetchUri');
    }

    function it_is_an_http_adapter_exception()
    {
        $this->shouldHaveType('Http\Adapter\Common\Exception\HttpAdapterException');
    }

    function it_is_thrown_when_an_uri_cannot_be_fetched()
    {
        $this->getMessage()
            ->shouldReturn('An error occurred when fetching the URI "/" with the adapter "common" ("Request failed").');

        $this->getCode()->shouldReturn(0);
    }
}
