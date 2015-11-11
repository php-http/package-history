<?php

namespace Http\Encoding;

/**
 * Stream inflate (RFC 1951)
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
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
