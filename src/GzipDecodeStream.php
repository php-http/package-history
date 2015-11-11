<?php

namespace Http\Encoding;

use GuzzleHttp\Psr7\LimitStream;
use Psr\Http\Message\StreamInterface;

class GzipDecodeStream extends FilteredStream
{
    public function __construct(StreamInterface $stream, $readFilterOptions = null, $writeFilterOptions = null)
    {
        // Gzip streaming is not handled by php, but by remove gzip it can act like a deflate stream
        $stream = new LimitStream($stream, -1, 10);

        parent::__construct($stream, $readFilterOptions, $writeFilterOptions);
    }

    public function getReadFilter()
    {
        return 'zlib.inflate';
    }

    public function getWriteFilter()
    {
        return 'zlib.deflate';
    }
}
