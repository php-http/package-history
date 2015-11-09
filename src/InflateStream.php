<?php

namespace Http\Encoding;

class InflateStream extends DecoratedStream
{
    protected $buffer;

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        var_dump(base64_encode(gzdeflate('This a test string')));
        return gzinflate($this->stream->getContents(), 4);

        return gz
    }
}
