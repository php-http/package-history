<?php

namespace spec\Http\Encoding;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

class GzipEncodeStreamSpec extends ObjectBehavior
{
    function it_is_initializable(StreamInterface $stream)
    {
        $this->beAnInstanceOf('Http\Encoding\GzipEncodeStream', [$stream]);
        $this->shouldImplement('Psr\Http\Message\StreamInterface');
    }
}
