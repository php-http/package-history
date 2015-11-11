<?php

namespace spec\Http\Encoding;

require_once __DIR__ . '/MemoryStream.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class ChunkStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\ChunkStream', [$stream]);
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_chunks_content()
    {
        $stream = new MemoryStream("This is a stream");
        $this->beConstructedWith($stream, 6);

        $this->getContents()->shouldReturn("10\r\nThis is a stream\r\n");
    }
}
