<?php

/*
 * This file is part of the Http Adapter Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Common\Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CannotFetchUri extends HttpAdapterException
{
    /**
     * @param string          $uri
     * @param string          $adapterName
     * @param \Exception|null $previous
     */
    public function __construct($uri, $adapterName, \Exception $previous = null)
    {
        $message = sprintf(
            'An error occurred when fetching the URI "%s" with the adapter "%s" ("%s").',
            $uri,
            $adapterName,
            isset($previous) ? $previous->getMessage() : ''
        );

        $code = isset($previous) ? $previous->getCode() : 0;

        parent::__construct($message, $code, $previous);
    }
}
