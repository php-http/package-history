<?php

namespace Http\Encoding;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\StreamWrapper;
use Psr\Http\Message\StreamInterface;

class InflateStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(StreamInterface $stream)
    {
        $resource = StreamWrapper::getResource($stream);
        stream_filter_append($resource, 'zlib.deflate', STREAM_FILTER_WRITE);
        stream_filter_append($resource, 'zlib.inflate', STREAM_FILTER_READ);
        $this->stream = new Stream($resource);
    }
}
