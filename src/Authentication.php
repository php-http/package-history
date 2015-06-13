<?php

/*
 * This file is part of the Authentication package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Authentication;

use Psr\Http\Message\RequestInterface;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface Authentication
{
    /**
     * Authenticates a request
     *
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    public function authenticate(RequestInterface $request);
}
