<?php

namespace Http\Encoding;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\StreamWrapper;
use Psr\Http\Message\StreamInterface;
use Clue\StreamFilter as Filter;

class GzipEncodeStream extends FilteredStream
{
    protected $hash;

    protected $crc32;

    public function __construct(StreamInterface $stream, $readFilterOptions = null, $writeFilterOptions = null)
    {
        $this->buffer = substr(gzencode(''), 0, 10);
        $this->hash   = hash_init('crc32b');

        $resource                  = StreamWrapper::getResource($stream);
        $this->readFilterCallback  = Filter\fun($this->getReadFilter(), $readFilterOptions);
        $this->writeFilterCallback = Filter\fun($this->getWriteFilter(), $writeFilterOptions);

        // Add a filter to write the crc32 checksum
        Filter\append($resource, function ($chunk = null) {
            if ($chunk !== null) {
                hash_update($this->hash, $chunk);
            }

            return $chunk;
        }, STREAM_FILTER_READ);

        $this->readFilter          = Filter\append($resource, $this->readFilterCallback, STREAM_FILTER_READ);
        $this->writeFilter         = Filter\append($resource, $this->writeFilterCallback, STREAM_FILTER_WRITE);
        $this->stream              = new Stream($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function getReadFilter()
    {
        return 'zlib.deflate';
    }

    /**
     * {@inheritdoc}
     */
    public function getWriteFilter()
    {
        return 'zlib.inflate';
    }

    /**
     * {@inheritdoc}
     */
    protected function fill()
    {
        while (!$this->stream->eof() && strlen($this->buffer) < self::BUFFER_SIZE) {
            $this->buffer .= $this->stream->read(self::BUFFER_SIZE);
        }

        if ($this->stream->eof()) {
            $readFilterCallback = $this->readFilterCallback;
            $this->buffer .= $readFilterCallback();
        }

        if ($this->stream->eof()) {
            $size = $this->stream->getSize() % pow(2, 32);

            $this->buffer .= pack('V', hexdec(hash_final($this->hash, false)));
            $this->buffer .= pack('V', $size);
        }
    }
}
