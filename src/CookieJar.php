<?php

/*
 * This file is part of the Http Cookie package.
 *
 * (c) PHP HTTP Team <team@php-http.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Cookie;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
interface CookieJar extends \Countable, \IteratorAggregate
{
    /**
     * Checks if there is a cookie
     *
     * @param Cookie $cookie
     *
     * @return boolean
     */
    public function hasCookie(Cookie $cookie);

    /**
     * Adds a cookie
     *
     * @param Cookie $cookie
     */
    public function addCookie(Cookie $cookie);

    /**
     * Removes a cookie
     *
     * @param Cookie $cookie
     */
    public function removeCookie(Cookie $cookie);

    /**
     * Returns the cookies
     *
     * @return Cookie[]
     */
    public function getCookies();

    /**
     * Returns all matching cookies
     *
     * @param Cookie $cookie
     *
     * @return Cookie[]
     */
    public function getMatchingCookies(Cookie $cookie);

    /**
     * Checks if there are cookies
     *
     * @return boolean
     */
    public function hasCookies();

    /**
     * Sets the cookies and removes any previous one
     *
     * @param Cookie[] $cookies
     */
    public function setCookies(array $cookies);

    /**
     * Adds some cookies
     *
     * @param Cookie[] $cookies
     */
    public function addCookies(array $cookies);

    /**
     * Removes some cookies
     *
     * @param Cookie[] $cookies
     */
    public function removeCookies(array $cookies);

    /**
     * Removes cookies which match the given parameters
     *
     * Null means that parameter should not be matched
     *
     * @param string|null $name
     * @param string|null $domain
     * @param string|null $path
     */
    public function removeMatchingCookies($name = null, $domain = null, $path = null);

    /**
     * Removes all cookies
     */
    public function clear();
}
