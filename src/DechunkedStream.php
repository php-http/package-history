<?php

namespace Http\Encoding;

use Psr\Http\Message\StreamInterface;

/**
 * Decorate a stream which is chunked
 *
 * Allow to decode a chunked stream
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class DechunkedStream extends DecoratedStream
{
    /**
     * @var string Internal buffer used when user read less content than available in a chunk
     */
    private $buffer;
    /**
     * @var boolean A chunked stream is eof when the 0 length chunk has been received.
     */
    private $eof;

    /**
     * {@inheritdoc}
     */
    public function __construct(StreamInterface $stream)
    {
        if (!$stream->isReadable()) {
            throw new \LogicException("Cannot dechunk a not readable stream");
        }

        parent::__construct($stream);

        $this->buffer = '';
        $this->eof    = $stream->eof();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getContents();
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     *
     * Internally use the 0 length chunk to say it's eof
     */
    public function eof()
    {
        return $this->eof;
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        if (strlen($this->buffer) >= $length) {
            $readed = substr($this->buffer, 0, $length);
            $this->buffer = substr($this->buffer, $length, strlen($this->buffer));

            return $readed;
        }

        $readed = '';

        // If buffer not empty, initalize readed string with content left
        if (strlen($this->buffer) > 0) {
            $readed = $this->buffer;
            $length = $length - strlen($this->buffer);

            $this->buffer = '';
        }

        if ($this->eof()) {
            return $readed;
        }

        // Set the buffer to the next chunk
        $this->buffer = $this->readChunk();

        return $readed . $this->read($length);
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        // TODO: Implement getContents() method.
    }

    /**
     * Read the next chunk available for this stream
     *
     * @return string|false Return string for the next chunk or false if last chunk has been read
     */
    public function readChunk()
    {
        // Get length of the chunk

    }
}
