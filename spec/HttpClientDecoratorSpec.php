<?php

namespace spec\Http\Client\Tools;

use Http\Client\HttpClient;
use Http\Client\Tools\HttpClientDecorator;
use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Prophecy\Argument;

class HttpClientDecoratorSpec extends ObjectBehavior
{
    function let(HttpClient $httpClient)
    {
        $this->beAnInstanceOf('spec\Http\Client\Tools\HttpClientDecoratorStub', [$httpClient]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('spec\Http\Client\Tools\HttpClientDecoratorStub');
    }

    function it_is_an_http_client()
    {
        $this->shouldImplement('Http\Client\HttpClient');
    }

    function it_decorates_the_underlying_client(HttpClient $httpClient, RequestInterface $request, ResponseInterface $response)
    {
        $httpClient->sendRequest($request)->willReturn($response);

        $this->sendRequest($request)->shouldReturn($response);
    }
}

class HttpClientDecoratorStub implements HttpClient
{
    use HttpClientDecorator;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
