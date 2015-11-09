<?php

namespace spec\Http\Encoding;

require_once __DIR__ . '/MemoryStream.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class ChunkedStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\ChunkedStream', [$stream]);
        $this->shouldImplement('Http\Encoding\DecoratedStream');
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_reads()
    {
        $stream = new MemoryStream("This is a stream");
        $this->beConstructedWith($stream);

        $this->read(6)->shouldReturn("6\r\nThis i\r\n");
    }

    function it_gets_content()
    {
        $stream = new MemoryStream("This is a stream");
        $this->beConstructedWith($stream, 6);

        $this->getContents()->shouldReturn("6\r\nThis i\r\n6\r\ns a st\r\n4\r\nream\r\n0\r\n\r\n");
    }
}
