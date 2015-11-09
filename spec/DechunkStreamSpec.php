<?php

namespace spec\Http\Encoding;

require_once __DIR__ . '/MemoryStream.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class DechunkStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\DechunkStream', [$stream]);
        $this->shouldImplement('Http\Encoding\DecoratedStream');
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_reads_chunk()
    {
        $stream = new MemoryStream("4\r\ntest\r\n0\r\n\r\n\0");
        $this->beConstructedWith($stream);

        $this->readChunk()->shouldReturn('test');
        $this->readChunk()->shouldReturn(false);
    }

    function it_gets_content()
    {
        $stream = new MemoryStream("4\r\ntest\r\n0\r\n\r\n\0");
        $this->beConstructedWith($stream);

        $this->getContents()->shouldReturn('test');
    }

    function it_reads()
    {
        $stream = new MemoryStream("4\r\ntest\r\n4\r\ntest\r\n0\r\n\r\n\0");
        $this->beConstructedWith($stream);

        $this->read(6)->shouldReturn('testte');
        $this->read(6)->shouldReturn('st');
    }

    function it_returns_no_size(StreamInterface $stream)
    {
        $this->beConstructedWith($stream);
        $stream->isReadable()->shouldBeCalled()->willReturn(true);
        $stream->eof()->shouldBeCalled()->willReturn(false);

        $this->getSize()->shouldReturn(null);
    }
}
