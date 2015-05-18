<?php

namespace spec\Http\Adapter\Common;

use Http\Adapter\HttpAdapter as HttpAdapterInterface;
use Http\Adapter\Common\HttpAdapter as HttpAdapterTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;

class HttpAdapterSpec extends ObjectBehavior
{
    function let(ResponseInterface $response)
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Common\HttpAdapterStub', [$response]);
    }

    function it_is_configurable_http_adapter()
    {
        $this->shouldImplement('Http\Adapter\HttpAdapter');
    }

    function it_executes_a_get_request(ResponseInterface $response)
    {
        $this->get('/', [])->shouldReturn($response);
    }

    function it_executes_a_head_request(ResponseInterface $response)
    {
        $this->head('/', [])->shouldReturn($response);
    }

    function it_executes_a_trace_request(ResponseInterface $response)
    {
        $this->trace('/', [])->shouldReturn($response);
    }

    function it_executes_a_post_request(ResponseInterface $response)
    {
        $this->post('/', [], [], [])->shouldReturn($response);
    }

    function it_executes_a_put_request(ResponseInterface $response)
    {
        $this->put('/', [], [], [])->shouldReturn($response);
    }

    function it_executes_a_patch_request(ResponseInterface $response)
    {
        $this->patch('/', [], [], [])->shouldReturn($response);
    }

    function it_executes_a_delete_request(ResponseInterface $response)
    {
        $this->delete('/', [], [], [])->shouldReturn($response);
    }

    function it_executes_a_options_request(ResponseInterface $response)
    {
        $this->options('/', [], [], [])->shouldReturn($response);
    }
}

class HttpAdapterStub implements HttpAdapterInterface
{
    use HttpAdapterTrait;

    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function send($method, $uri, array $headers = [], $data = [], array $files = [])
    {
        return $this->response;
    }

    public function sendRequest(RequestInterface $request)
    {

    }

    public function sendRequests(array $requests)
    {

    }

    public function getName()
    {
        return 'common';
    }
}
