<?php

namespace spec\Http\Client\Tools;

use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Client\Tools\HttpAsyncClientEmulator;
use Http\Client\Tools\HttpClientDecorator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpAsyncClientEmulatorSpec extends ObjectBehavior
{
    function let(HttpClient $httpClient)
    {
        $this->beAnInstanceOf('spec\Http\Client\Tools\HttpAsyncClientEmulatorStub', [$httpClient]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('spec\Http\Client\Tools\HttpAsyncClientEmulatorStub');
    }

    function it_emulates_a_successful_request(HttpClient $httpClient, RequestInterface $request, ResponseInterface $response)
    {
        $httpClient->sendRequest($request)->willReturn($response);

        $this->sendAsyncRequest($request)->shouldReturnAnInstanceOf('Http\Client\Tools\Promise\FulfilledPromise');
    }

    function it_emulates_a_failed_request(HttpClient $httpClient, RequestInterface $request)
    {
        $httpClient->sendRequest($request)->willThrow('Http\Client\Exception\TransferException');

        $this->sendAsyncRequest($request)->shouldReturnAnInstanceOf('Http\Client\Tools\Promise\RejectedPromise');
    }
}

class HttpAsyncClientEmulatorStub implements HttpClient, HttpAsyncClient
{
    use HttpClientDecorator;
    use HttpAsyncClientEmulator;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
