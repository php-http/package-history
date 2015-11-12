<?php

namespace spec\Http\Encoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class CompressStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\CompressStream', [$stream]);
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_reads()
    {
        $stream = new MemoryStream("This is a test stream");
        $this->beConstructedWith($stream);

        $stream->rewind();
        $this->read(4)->shouldReturn(substr(gzcompress("This is a test stream"), 0, 4));
    }

    function it_gets_content()
    {
        $stream = new MemoryStream("This is a test stream");
        $this->beConstructedWith($stream);

        $stream->rewind();
        $this->getContents()->shouldReturn(gzcompress("This is a test stream"));
    }
}
