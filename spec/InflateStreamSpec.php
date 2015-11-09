<?php

namespace spec\Http\Encoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class InflateStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\InflateStream', [$stream]);
        $this->shouldImplement('Http\Encoding\DecoratedStream');
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_reads_stream()
    {
        // "This is a test stream" | deflate
        $stream = new MemoryStream(base64_decode("C8nILFZIVChJLS5RKC4pysxLBwA="));
        $this->beConstructedWith($stream);

        $this->read(4)->shouldReturn('This');
    }
}
