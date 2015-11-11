<?php

namespace Http\Encoding;

class InflateStream extends FilteredStream
{
    public function getReadFilter()
    {
        return 'zlib.inflate';
    }

    public function getWriteFilter()
    {
        return 'zlib.deflate';
    }
}
