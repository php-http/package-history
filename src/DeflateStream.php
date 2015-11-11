<?php

namespace Http\Encoding;

class DeflateStream extends FilteredStream
{
    public function getReadFilter()
    {
        return 'zlib.deflate';
    }

    public function getWriteFilter()
    {
        return 'zlib.inflate';
    }
}
