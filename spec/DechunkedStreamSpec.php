<?php

namespace spec\Http\Encoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class DechunkedStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\DechunkedStream', [$stream]);
        $this->shouldImplement('Http\Encoding\DecoratedStream');
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_dechunks_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
    }

    function it_returns_no_size(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->isReadable()->shouldBeCalled()->willReturn(true);
        $stream->eof()->shouldBeCalled()->willReturn(false);

        $this->getSize()->shouldReturn(null);
    }
}
