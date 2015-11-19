<?php

namespace spec\Http\Client\Tools;

use Http\Client\Exception\TransferException;
use Http\Client\HttpClient;
use Http\Client\HttpAsyncClient;
use Http\Client\Promise;
use Http\Client\Tools\HttpClientEmulator;
use Http\Client\Tools\HttpAsyncClientDecorator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpClientEmulatorSpec extends ObjectBehavior
{
    function let(HttpAsyncClient $httpAsyncClient)
    {
        $this->beAnInstanceOf('spec\Http\Client\Tools\HttpClientEmulatorStub', [$httpAsyncClient]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('spec\Http\Client\Tools\HttpClientEmulatorStub');
    }

    function it_emulates_a_successful_request(HttpAsyncClient $httpAsyncClient, RequestInterface $request, Promise $promise, ResponseInterface $response)
    {
        $promise->wait()->shouldBeCalled();
        $promise->getState()->willReturn(Promise::FULFILLED);
        $promise->getResponse()->willReturn($response);

        $httpAsyncClient->sendAsyncRequest($request)->willReturn($promise);

        $this->sendRequest($request)->shouldReturn($response);
    }

    function it_emulates_a_failed_request(HttpAsyncClient $httpAsyncClient, RequestInterface $request, Promise $promise)
    {
        $promise->wait()->shouldBeCalled();
        $promise->getState()->willReturn(Promise::REJECTED);
        $promise->getException()->willReturn(new TransferException());

        $httpAsyncClient->sendAsyncRequest($request)->willReturn($promise);

        $this->shouldThrow('Http\Client\Exception')->duringSendRequest($request);
    }
}

class HttpClientEmulatorStub implements HttpAsyncClient, HttpClient
{
    use HttpAsyncClientDecorator;
    use HttpClientEmulator;

    /**
     * @param HttpAsyncClient $httpAsyncClient
     */
    public function __construct(HttpAsyncClient $httpAsyncClient)
    {
        $this->httpAsyncClient = $httpAsyncClient;
    }
}
