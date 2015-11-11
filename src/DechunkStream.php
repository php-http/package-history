<?php

namespace Http\Encoding;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\StreamWrapper;
use Psr\Http\Message\StreamInterface;

/**
 * Decorate a stream which is chunked
 *
 * Allow to decode a chunked stream
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class DechunkStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(StreamInterface $stream)
    {
        $resource = StreamWrapper::getResource($stream);
        stream_filter_append($resource, 'chunk', STREAM_FILTER_WRITE);
        stream_filter_append($resource, 'dechunk', STREAM_FILTER_READ);
        $this->stream = new Stream($resource);
    }
}

if (!array_key_exists('chunk', stream_get_filters())) {
    stream_filter_register('chunk', 'Http\Encoding\Filter\Chunk');
}
