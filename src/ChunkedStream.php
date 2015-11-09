<?php

namespace Http\Encoding;

use Psr\Http\Message\StreamInterface;

/**
 * Transform a regular stream into a chunked one
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class ChunkedStream extends DecoratedStream
{
    const DEFAULT_BUFFER_SIZE = 8192;

    /**
     * @var int Buffer size used when reading the full stream
     */
    private $bufferSize;

    /**
     * {@inheritdoc}
     *
     * @param int $bufferSIze Buffer size used when reading the full stream
     */
    public function __construct(StreamInterface $stream, $bufferSize = self::DEFAULT_BUFFER_SIZE)
    {
        if (!$stream->isReadable()) {
            throw new \LogicException("Cannot chunk a not readable stream");
        }

        parent::__construct($stream);

        $this->bufferSize = $bufferSize;
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        $buffer = $this->stream->read($length);

        return sprintf("%s\r\n%s\r\n", strlen($buffer), $buffer);
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        $content = '';

        while (!$this->stream->eof()) {
            $content .= $this->read($this->bufferSize);
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getContents();
    }
}
