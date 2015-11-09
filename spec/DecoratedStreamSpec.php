<?php

namespace spec\Http\Encoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class DecoratedStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\DecoratedStream', [$stream]);
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_returns_undelying_to_string(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->__toString()->shouldBeCalled()->willReturn('stream');

        $this->__toString()->shouldReturn('stream');
    }

    function it_closes_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->close()->shouldBeCalled();

        $this->close();
    }

    function it_detach_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->detach()->shouldBeCalled()->willReturn('socket');

        $this->detach()->shouldReturn('socket');
    }

    function it_gets_size_from_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->getSize()->shouldBeCalled()->willReturn(50);

        $this->getSize()->shouldReturn(50);
    }

    function it_tells_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->tell()->shouldBeCalled()->willReturn(10);

        $this->tell()->shouldReturn(10);
    }

    function it_eof_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->eof()->shouldBeCalled()->willReturn(true);

        $this->eof()->shouldReturn(true);
    }

    function it_is_seekable_with_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->isSeekable()->shouldBeCalled()->willReturn(true);

        $this->isSeekable()->shouldReturn(true);
    }

    function it_seeks_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->seek(0, SEEK_END)->shouldBeCalled();

        $this->seek(0, SEEK_END);
    }

    function it_rewind_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->rewind()->shouldBeCalled();

        $this->rewind();
    }

    function it_is_writable_with_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->isWritable()->shouldBeCalled()->willReturn(true);

        $this->isWritable()->shouldReturn(true);
    }

    function it_writes_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->write('test')->shouldBeCalled()->willReturn(4);

        $this->write('test')->shouldReturn(4);
    }

    function it_is_readable_with_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->isReadable()->shouldBeCalled()->willReturn(true);

        $this->isReadable()->shouldReturn(true);
    }

    function it_reads_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->read(4)->shouldBeCalled()->willReturn('test');

        $this->read(4)->shouldReturn('test');
    }

    function it_gets_contents_from_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->getContents()->shouldBeCalled()->willReturn('test');

        $this->getContents()->shouldReturn('test');
    }

    function it_gets_metadata_from_underlying_stream(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->getMetadata('key')->shouldBeCalled()->willReturn('value');
        $stream->getMetadata(null)->shouldBeCalled()->willReturn([]);

        $this->getMetadata('key')->shouldReturn('value');
        $this->getMetadata()->shouldReturn([]);
    }
}
