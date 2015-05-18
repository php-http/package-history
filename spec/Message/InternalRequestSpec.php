<?php

namespace spec\Http\Adapter\Core\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InternalRequestSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            null,
            null,
            [],
            'php://memory',
            [
                'data' => 'value',
            ],
            [
                'file' => '/tmp/test',
            ]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
    }

    function it_has_data()
    {
        $this->getData('data')->shouldReturn('value');
        $this->getAllData()->shouldReturn(['data' => 'value']);
        $this->hasData('data')->shouldReturn(true);
        $this->hasAnyData()->shouldReturn(true);
    }

    function it_accepts_data()
    {
        $internalRequest = $this->withData('data', 'value2');
        $internalRequest->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
        $internalRequest->getData('data')->shouldReturn('value2');

        $internalRequest = $internalRequest->withAddedData('data', 'value3');
        $internalRequest->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
        $internalRequest->getData('data')->shouldReturn(['value2', 'value3']);
    }

    function it_removes_data()
    {
        $internalRequest = $this->withoutData('data');
        $internalRequest->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
        $internalRequest->hasData('data')->shouldReturn(false);
    }

    function it_has_files()
    {
        $this->getFile('file')->shouldReturn('/tmp/test');
        $this->getFiles()->shouldReturn(['file' => '/tmp/test']);
        $this->hasFile('file')->shouldReturn(true);
        $this->hasFiles()->shouldReturn(true);
    }

    function it_accepts_files()
    {
        $internalRequest = $this->withFile('file', '/tmp/test2');
        $internalRequest->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
        $internalRequest->getFile('file')->shouldReturn('/tmp/test2');

        $internalRequest = $internalRequest->withAddedFile('file', '/tmp/test3');
        $internalRequest->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
        $internalRequest->getFile('file')->shouldReturn(['/tmp/test2', '/tmp/test3']);
    }

    function it_removes_files()
    {
        $internalRequest = $this->withoutFile('file');
        $internalRequest->shouldHaveType('Http\Adapter\Core\Message\InternalRequest');
        $internalRequest->hasFile('file')->shouldReturn(false);
    }
}
