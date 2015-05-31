<?php

/*
 * This file is part of the Message Decorator package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Message;

use Psr\Http\Message\ResponseInterface;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
trait ResponseDecorator
{
    use MessageDecorator;

    /**
     * Exchanges the underlying response with another
     *
     * @param ResponseInterface $response
     *
     * @return self
     */
    public function withResponse(ResponseInterface $response)
    {
        $new = clone $this;
        $new->message = $response;

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->message->getStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $new = clone $this;
        $new->message = $this->message->withStatus($code, $reasonPhrase);

        return $new;
    }

    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase()
    {
        return $this->message->getReasonPhrase();
    }
}
