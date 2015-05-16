<?php

namespace spec\Http\Message;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;

class ResponseDecoratorSpec extends ObjectBehavior
{
    function let(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Message\ResponseDecorator');
    }

    function it_is_a_response()
    {
        $this->shouldImplement('Psr\Http\Message\ResponseInterface');
    }

    function it_has_a_response()
    {
        $this->getMessage()->shouldImplement('Psr\Http\Message\ResponseInterface');
    }

    function it_has_a_status_code(ResponseInterface $response)
    {
        $response->getStatusCode()->willReturn(200);

        $this->getStatusCode()->shouldReturn(200);
    }

    function it_accepts_a_status(ResponseInterface $response, ResponseInterface $newResponse)
    {
        $response->withStatus(200, 'OK')->willReturn($newResponse);

        $new = $this->withStatus(200, 'OK');
        $new->getMessage()->shouldReturn($newResponse);
    }

    function it_has_a_reason_phrase(ResponseInterface $response)
    {
        $response->getReasonPhrase()->willReturn('OK');

        $this->getReasonPhrase()->shouldReturn('OK');
    }

    /**
     * Message tests start here
     */

    function it_has_a_protocol_version(ResponseInterface $response)
    {
        $response->getProtocolVersion()->willReturn('1.1');

        $this->getProtocolVersion()->shouldReturn('1.1');
    }

    function it_accepts_a_protocol_version(ResponseInterface $response, ResponseInterface $newResponse)
    {
        $response->withProtocolVersion('1.1')->willReturn($newResponse);

        $new = $this->withProtocolVersion('1.1');
        $new->getMessage()->shouldReturn($newResponse);
    }

    function it_has_headers(ResponseInterface $response)
    {
        $headers = [
            'Content-Type' => 'application/xml'
        ];

        $response->getHeaders()->willReturn($headers);

        $this->getHeaders()->shouldReturn($headers);
    }

    function it_can_check_a_header(ResponseInterface $response)
    {
        $response->hasHeader('Content-Type')->willReturn(true);

        $this->hasHeader('Content-Type')->shouldReturn(true);
    }

    function it_has_a_header(ResponseInterface $response)
    {
        $response->getHeader('Content-Type')->willReturn('application/xml');

        $this->getHeader('Content-Type')->shouldReturn('application/xml');
    }

    function it_has_a_header_line(ResponseInterface $response)
    {
        $response->getHeaderLine('Accept-Encoding')->willReturn('gzip, deflate');

        $this->getHeaderLine('Accept-Encoding')->shouldReturn('gzip, deflate');
    }

    function it_accepts_a_header(ResponseInterface $response, ResponseInterface $newResponse)
    {
        $response->withHeader('Content-Type', 'application/xml')->willReturn($newResponse);

        $new = $this->withHeader('Content-Type', 'application/xml');
        $new->getMessage()->shouldReturn($newResponse);
    }

    function it_accepts_added_headers(ResponseInterface $response, ResponseInterface $newResponse)
    {
        $response->withAddedHeader('Content-Type', 'application/xml')->willReturn($newResponse);

        $new = $this->withAddedHeader('Content-Type', 'application/xml');
        $new->getMessage()->shouldReturn($newResponse);
    }

    function it_removes_a_header(ResponseInterface $response, ResponseInterface $newResponse)
    {
        $response->withoutHeader('Content-Type')->willReturn($newResponse);

        $new = $this->withoutHeader('Content-Type');
        $new->getMessage()->shouldReturn($newResponse);
    }

    function it_has_a_body(ResponseInterface $response, StreamInterface $body)
    {
        $response->getBody()->willReturn($body);

        $this->getBody()->shouldReturn($body);
    }

    function it_accepts_a_body(ResponseInterface $response, ResponseInterface $newResponse, StreamInterface $body)
    {
        $response->withBody($body)->willReturn($newResponse);

        $new = $this->withBody($body);
        $new->getMessage()->shouldReturn($newResponse);
    }
}
