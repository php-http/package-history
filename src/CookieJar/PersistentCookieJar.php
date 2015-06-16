<?php

/*
 * This file is part of the Http Cookie package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Cookie\CookieJar;

use Http\Cookie\CookieJar;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface PersistentCookieJar extends CookieJar
{
    /**
     * Loads the cookie jar
     *
     * @throws \RuntimeException
     */
    public function load();

    /**
     * Saves the cookie jar
     *
     * @throws \RuntimeException
     */
    public function save();
}
