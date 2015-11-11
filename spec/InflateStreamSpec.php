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
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_reads()
    {
        // "This is a test stream" | deflate
        $stream = new MemoryStream(gzdeflate('This is a test stream'));
        $this->beConstructedWith($stream);

        $this->read(4)->shouldReturn('This');
    }

    function it_gets_content()
    {
        // "This is a test stream" | deflate
        $stream = new MemoryStream(gzdeflate('This is a test stream'));
        $this->beConstructedWith($stream);

        $this->getContents()->shouldReturn('This is a test stream');
    }
}
