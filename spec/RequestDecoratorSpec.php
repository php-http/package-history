<?php

namespace spec\Http\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use PhpSpec\ObjectBehavior;

class RequestDecoratorSpec extends ObjectBehavior
{
    function let(RequestInterface $request)
    {
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Message\RequestDecorator');
    }

    function it_is_a_request()
    {
        $this->shouldImplement('Psr\Http\Message\RequestInterface');
    }

    function it_has_a_request()
    {
        $this->getMessage()->shouldImplement('Psr\Http\Message\RequestInterface');
    }

    function it_has_a_request_target(RequestInterface $request)
    {
        $request->getRequestTarget()->willReturn('/');

        $this->getRequestTarget()->shouldReturn('/');
    }

    function it_accepts_a_request_target(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withRequestTarget('/')->willReturn($newRequest);

        $new = $this->withRequestTarget('/');
        $new->getMessage()->shouldReturn($newRequest);
    }

    function it_has_a_method(RequestInterface $request)
    {
        $request->getMethod()->willReturn('GET');

        $this->getMethod()->shouldReturn('GET');
    }

    function it_accepts_a_method(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withMethod('GET')->willReturn($newRequest);

        $new = $this->withMethod('GET');
        $new->getMessage()->shouldReturn($newRequest);
    }

    function it_has_an_uri(RequestInterface $request, UriInterface $uri)
    {
        $request->getUri()->willReturn($uri);

        $this->getUri()->shouldReturn($uri);
    }

    function it_accepts_an_uri(RequestInterface $request, RequestInterface $newRequest, UriInterface $uri)
    {
        $request->withUri($uri, false)->willReturn($newRequest);

        $new = $this->withUri($uri);
        $new->getMessage()->shouldReturn($newRequest);
    }

    /**
     * Message tests start here
     */

    function it_has_a_protocol_version(RequestInterface $request)
    {
        $request->getProtocolVersion()->willReturn('1.1');

        $this->getProtocolVersion()->shouldReturn('1.1');
    }

    function it_accepts_a_protocol_version(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withProtocolVersion('1.1')->willReturn($newRequest);

        $new = $this->withProtocolVersion('1.1');
        $new->getMessage()->shouldReturn($newRequest);
    }

    function it_has_headers(RequestInterface $request)
    {
        $headers = [
            'Content-Type' => 'application/xml'
        ];

        $request->getHeaders()->willReturn($headers);

        $this->getHeaders()->shouldReturn($headers);
    }

    function it_can_check_a_header(RequestInterface $request)
    {
        $request->hasHeader('Content-Type')->willReturn(true);

        $this->hasHeader('Content-Type')->shouldReturn(true);
    }

    function it_has_a_header(RequestInterface $request)
    {
        $request->getHeader('Content-Type')->willReturn('application/xml');

        $this->getHeader('Content-Type')->shouldReturn('application/xml');
    }

    function it_has_a_header_line(RequestInterface $request)
    {
        $request->getHeaderLine('Accept-Encoding')->willReturn('gzip, deflate');

        $this->getHeaderLine('Accept-Encoding')->shouldReturn('gzip, deflate');
    }

    function it_accepts_a_header(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withHeader('Content-Type', 'application/xml')->willReturn($newRequest);

        $new = $this->withHeader('Content-Type', 'application/xml');
        $new->getMessage()->shouldReturn($newRequest);
    }

    function it_accepts_added_headers(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withAddedHeader('Content-Type', 'application/xml')->willReturn($newRequest);

        $new = $this->withAddedHeader('Content-Type', 'application/xml');
        $new->getMessage()->shouldReturn($newRequest);
    }

    function it_removes_a_header(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withoutHeader('Content-Type')->willReturn($newRequest);

        $new = $this->withoutHeader('Content-Type');
        $new->getMessage()->shouldReturn($newRequest);
    }

    function it_has_a_body(RequestInterface $request, StreamInterface $body)
    {
        $request->getBody()->willReturn($body);

        $this->getBody()->shouldReturn($body);
    }

    function it_accepts_a_body(RequestInterface $request, RequestInterface $newRequest, StreamInterface $body)
    {
        $request->withBody($body)->willReturn($newRequest);

        $new = $this->withBody($body);
        $new->getMessage()->shouldReturn($newRequest);
    }
}
