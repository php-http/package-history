<?php

/*
 * This file is part of the Http Adapter Core package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core\Message;

use Http\Adapter\Common\Message\MessageFactory as MessageFactoryParent;
use Http\Adapter\Internal\Message\MessageFactory as MessageFactoryInterface;
use Http\Adapter\Normalizer\HeaderNormalizer;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MessageFactory extends MessageFactoryParent implements MessageFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createInternalRequest(
        $method,
        $uri,
        $protocolVersion = '1.1',
        array $headers = [],
        $data = [],
        array $files = [],
        array $parameters = [],
        array $options = []
    ) {
        $body = null;

        if (!is_array($data)) {
            $body = $this->createStream($data);
            $data = $files = [];
        }

        return (new InternalRequest(
            $method,
            $this->createUri($uri),
            HeaderNormalizer::normalize($headers),
            $body !== null ? $body : 'php://memory',
            $data,
            $files,
            $parameters,
            $options
        ))->withProtocolVersion($protocolVersion);
    }
}
