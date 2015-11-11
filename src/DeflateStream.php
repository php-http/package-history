<?php

namespace Http\Encoding;

/**
 * Stream deflate (RFC 1951)
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
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
