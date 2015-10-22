<?php

namespace Http\Authentication;

use Psr\Http\Message\RequestInterface;

/**
 * Authenticate a PSR-7 Request using Basic Auth
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class BasicAuth implements Authentication
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Returns the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Returns the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(RequestInterface $request)
    {
        $header = sprintf('Basic %s', base64_encode(sprintf('%s:%s', $this->username, $this->password)));

        return $request->withHeader('Authorization', $header);
    }
}
