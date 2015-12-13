<?php

namespace spec\Http\Client\Tools;

use Http\Client\HttpAsyncClient;
use Http\Client\Tools\HttpAsyncClientDecorator;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpAsyncClientDecoratorSpec extends ObjectBehavior
{
    function let(HttpAsyncClient $httpAsyncClient)
    {
        $this->beAnInstanceOf('spec\Http\Client\Tools\HttpAsyncClientDecoratorStub', [$httpAsyncClient]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('spec\Http\Client\Tools\HttpAsyncClientDecoratorStub');
    }

    function it_is_an_http_async_client()
    {
        $this->shouldImplement('Http\Client\HttpAsyncClient');
    }

    function it_decorates_the_underlying_client(HttpAsyncClient $httpAsyncClient, RequestInterface $request, Promise $promise)
    {
        $httpAsyncClient->sendAsyncRequest($request)->willReturn($promise);

        $this->sendAsyncRequest($request)->shouldReturn($promise);
    }
}

class HttpAsyncClientDecoratorStub implements HttpAsyncClient
{
    use HttpAsyncClientDecorator;

    /**
     * @param HttpAsyncClient $httpAsyncClient
     */
    public function __construct(HttpAsyncClient $httpAsyncClient)
    {
        $this->httpAsyncClient = $httpAsyncClient;
    }
}
