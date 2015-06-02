<?php

namespace spec\Http\Adapter\Message;

use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;

class InternalRequestSpec extends ObjectBehavior
{
    function let(RequestInterface $request)
    {
        $this->beConstructedWith(
            $request,
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
        $this->shouldHaveType('Http\Adapter\Message\InternalRequest');
    }

    function it_is_an_internal_request()
    {
        $this->shouldImplement('Http\Client\Message\InternalRequest');
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
        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
        $internalRequest->getData('data')->shouldReturn('value2');

        $internalRequest = $internalRequest->withAddedData('data', 'value3');
        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
        $internalRequest->getData('data')->shouldReturn(['value2', 'value3']);
    }

    function it_removes_data()
    {
        $internalRequest = $this->withoutData('data');
        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
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
        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
        $internalRequest->getFile('file')->shouldReturn('/tmp/test2');

        $internalRequest = $internalRequest->withAddedFile('file', '/tmp/test3');
        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
        $internalRequest->getFile('file')->shouldReturn(['/tmp/test2', '/tmp/test3']);
    }

    function it_removes_files()
    {
        $internalRequest = $this->withoutFile('file');
        $internalRequest->shouldImplement('Http\Client\Message\InternalRequest');
        $internalRequest->hasFile('file')->shouldReturn(false);
    }
}
