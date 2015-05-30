<?php

/*
 * This file is part of the Http Common package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Common\Message;

use Http\Message\ClientContextFactory;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class MessageFactoryGuesser
{
    /**
     * List of message factories and classes to be checked
     *
     * Check Guzzle first: expected to be more commonly used (PHP version compat)
     *
     * @var array
     */
    protected static $messageFactories = [
        'guzzle' => [
            'class'   => 'GuzzleHttp\Psr7\Request',
            'factory' => 'Http\Common\Message\MessageFactory\GuzzleFactory',
        ],
        'diactoros' => [
            'class'   => 'Zend\Diactoros\Request',
            'factory' => 'Http\Common\Message\MessageFactory\DiactorosFactory',
        ],
    ];

    /**
     * Registers a custom factory
     *
     * @param string $name
     * @param string $class
     * @param string $factory
     */
    public static function register($name, $class, $factory)
    {
        static::$messageFactories[$name] = [
            'class'   => $class,
            'factory' => $factory,
        ];
    }

    /**
     * Unregisters a factory
     *
     * @param string $name
     */
    public static function unregister($name)
    {
        if (isset(static::$messageFactories[$name])) {
            unset(static::$messageFactories[$name]);
        }
    }

    /**
     * Guesses a factory
     *
     * @return ClientContextFactory
     *
     * @throws \RuntimeException If no message factory is available
     */
    public static function guess()
    {
        foreach (static::$messageFactories as $name => $definition) {
            if (class_exists($definition['class'])) {
                return new $definition['factory'];
            }
        }

        throw new \RuntimeException('No available Message Factories found');
    }
}
