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
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }

    function it_reads()
    {
        $stream = new MemoryStream("4\r\ntest\r\n4\r\ntest\r\n0\r\n\r\n\0");
        $this->beConstructedWith($stream);

        $this->read(6)->shouldReturn('testte');
        $this->read(6)->shouldReturn('st');
    }

    function it_gets_content()
    {
        $stream = new MemoryStream("4\r\ntest\r\n0\r\n\r\n\0");
        $this->beConstructedWith($stream);

        $this->getContents()->shouldReturn('test');
    }
}
