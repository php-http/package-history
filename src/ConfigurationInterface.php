<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter;

use Http\Adapter\Message\MessageFactoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
interface ConfigurationInterface
{
    /** @const string */
    const ENCODING_TYPE_URLENCODED = 'application/x-www-form-urlencoded';

    /** @const string */
    const ENCODING_TYPE_FORMDATA = 'multipart/form-data';

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
     * Returns the encoding type
     *
     * @return string|null
     */
    public function getEncodingType();

    /**
     * Checks if there is an encoding type
     *
     * @return boolean
     */
    public function hasEncodingType();

    /**
     * Sets the encoding type.
     *
     * @param string|null $encodingType
     */
    public function setEncodingType($encodingType);

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
     * @return integer
     */
    public function getTimeout();

    /**
     * Sets the timeout (in seconds)
     *
     * @param integer $timeout
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
