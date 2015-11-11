<?php

namespace spec\Http\Encoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class GzipDecodeStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\GzipDecodeStream', [$stream]);
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }
}
