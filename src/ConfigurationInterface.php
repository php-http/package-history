<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core;

use Http\Adapter\Message\MessageFactoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
interface ConfigurationInterface
{
    /** @const string */
    const CONTENT_TYPE_URLENCODED = 'application/x-www-form-urlencoded';

    /** @const string */
    const CONTENT_TYPE_FORMDATA = 'multipart/form-data';

    /**
     * Returns the message factory
     *
     * @return MessageFactoryInterface
     */
    public function getMessageFactory();

    /**
     * Sets the message factory
     *
     * @param MessageFactoryInterface $messageFactory
     */
    public function setMessageFactory(MessageFactoryInterface $messageFactory);

    /**
     * Returns the protocol version
     *
     * @return string
     */
    public function getProtocolVersion();

    /**
     * Sets the protocol version.
     *
     * @param string $protocolVersion
     */
    public function setProtocolVersion($protocolVersion);

    /**
     * Checks if it is kept alive
     *
     * @return boolean
     */
    public function isKeptAlive();

    /**
     * Sets if it is kept alive
     *
     * @param boolean $keepAlive
     */
    public function setKeepAlive($keepAlive);

    /**
     * Returns the content type
     *
     * @return string|null
     */
    public function getContentType();

    /**
     * Checks if there is a content type
     *
     * @return boolean
     */
    public function hasContentType();

    /**
     * Sets the content type.
     *
     * @param string|null $contentType
     */
    public function setContentType($contentType);

    /**
     * Returns the boundary
     *
     * @return string
     */
    public function getBoundary();

    /**
     * Sets the boundary
     *
     * @param string $boundary
     */
    public function setBoundary($boundary);

    /**
     * Returns the timeout (in seconds)
     *
     * @return float
     */
    public function getTimeout();

    /**
     * Sets the timeout (in seconds)
     *
     * @param float $timeout
     */
    public function setTimeout($timeout);

    /**
     * Returns the user agent
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Sets the user agent
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent);

    /**
     * Returns the base uri
     *
     * @return string
     */
    public function getBaseUri();

    /**
     * Checks if there is a base uri
     *
     * @return boolean
     */
    public function hasBaseUri();

    /**
     * Sets the base uri
     *
     * @param string $baseUri
     */
    public function setBaseUri($baseUri);
}
