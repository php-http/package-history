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
 *
 * @see http://tools.ietf.org/search/rfc6265
 */
final class Cookie
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $value;

    /**
     * @var integer|null
     */
    protected $maxAge;

    /**
     * @var \DateTime|null
     */
    protected $expires;

    /**
     * @var string|null
     */
    protected $domain;

    /**
     * @var string|null
     */
    protected $path;

    /**
     * @var boolean
     */
    protected $secure;

    /**
     * @var boolean
     */
    protected $httpOnly;

    /**
     * @param string            $name
     * @param string|null       $value
     * @param integer|\DateTime $expiration
     * @param string|null       $domain
     * @param string            $path
     * @param boolean           $secure
     * @param boolean           $httpOnly
     */
    public function __construct(
        $name,
        $value = null,
        $expiration = 0,
        $domain = null,
        $path = '/',
        $secure = false,
        $httpOnly = false
    ) {
        if (strlen($name) < 1) {
            throw new \InvalidArgumentException('The name cannot be empty');
        }

        /**
         * Name attribute is a token defined by RFC2616
         *
         * @see http://tools.ietf.org/search/rfc2616#section-2.2
         */
        if (preg_match('/[\x00-\x20]|\x22|[\x28-\x29]|\x2c|\x2f|[\x3a-\x40]|[\x5b-\x5d]|\x7b|\x7d|\x7f/', $name)) {
            throw new \InvalidArgumentException(sprintf('The cookie name "%s" contains invalid characters.', $name));
        }

        $maxAge = null;
        $expires = null;

        if (is_int($expiration)) {
            $maxAge = $expiration;
            $expires = new \DateTime(sprintf('%d seconds', $maxAge));

            // According to RFC2616 date should be set to earliest representable date
            if ($maxAge <= 0) {
                $expires->setTimestamp(-PHP_INT_MAX);
            }

        } elseif ($expiration instanceof \DateTime) {
            $expires = $expiration;
        }

        $this->name = $name;
        $this->value = $value;
        $this->maxAge = $maxAge;
        $this->expires = $expires;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = (bool) $secure;
        $this->httpOnly = (bool) $httpOnly;
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Checks if there is a value
     *
     * @return boolean
     */
    public function hasValue()
    {
        return isset($this->value);
    }

    /**
     * Returns the max age
     *
     * @return integer|null
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * Checks if there is a max age
     *
     * @return boolean
     */
    public function hasMaxAge()
    {
        return isset($this->maxAge);
    }

    /**
     * Returns the expiration time
     *
     * @return \DateTime|null
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Checks if there is an expiration time
     *
     * @return boolean
     */
    public function hasExpires()
    {
        return isset($this->expires);
    }

    /**
     * Checks if the cookie is expired
     *
     * @return boolean
     */
    public function isExpired()
    {
        return isset($this->expires) and $this->expires < new \DateTime();
    }

    /**
     * Returns the domain
     *
     * @return string|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Checks if there is a domain
     *
     * @return boolean
     */
    public function hasDomain()
    {
        return isset($this->domain);
    }

    /**
     * Returns the path
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Checks if there is a path
     *
     * @return boolean
     */
    public function hasPath()
    {
        return isset($this->path);
    }

    /**
     * Checks if HTTPS is required
     *
     * @return boolean
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * Checks if it is HTTP-only
     *
     * @return boolean
     */
    public function isHttpOnly()
    {
        return $this->httpOnly;
    }
}
