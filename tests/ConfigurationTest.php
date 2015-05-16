<?php

/*
 * This file is part of the Ivory Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core\Tests;

use Http\Adapter\Core\Configuration;
use Http\Adapter\HttpAdapter;
use Http\Adapter\Message\InternalRequestInterface;
use Http\Adapter\Message\MessageFactoryInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->configuration = new Configuration();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->configuration);
    }

    public function testDefaultState()
    {
        $this->assertInstanceOf('Http\Adapter\Core\Message\MessageFactory', $this->configuration->getMessageFactory());
        $this->assertSame(InternalRequestInterface::PROTOCOL_VERSION_1_1, $this->configuration->getProtocolVersion());
        $this->assertFalse($this->configuration->isKeptAlive());
        $this->assertFalse($this->configuration->hasContentType());
        $this->assertInternalType('string', $this->configuration->getBoundary());
        $this->assertSame(10, $this->configuration->getTimeout());
        $this->assertSame('PHP Http Adapter', $this->configuration->getUserAgent());
        $this->assertFalse($this->configuration->hasBaseUri());
    }

    public function testInitialState()
    {
        $this->configuration = new Configuration($messageFactory = $this->createMessageFactoryMock());

        $this->assertSame($messageFactory, $this->configuration->getMessageFactory());
    }

    public function testSetMessageFactory()
    {
        $this->configuration->setMessageFactory($messageFactory = $this->createMessageFactoryMock());

        $this->assertSame($messageFactory, $this->configuration->getMessageFactory());
    }

    public function testSetProtocolVersion()
    {
        $this->configuration->setProtocolVersion($protocolVersion = InternalRequestInterface::PROTOCOL_VERSION_1_0);

        $this->assertSame($protocolVersion, $this->configuration->getProtocolVersion());
    }

    public function testSetKeepAlive()
    {
        $this->configuration->setKeepAlive(true);

        $this->assertTrue($this->configuration->isKeptAlive());
    }

    public function testSetContentType()
    {
        $this->configuration->setContentType($encodingType = Configuration::CONTENT_TYPE_FORMDATA);

        $this->assertSame($encodingType, $this->configuration->getContentType());
    }

    public function testSetBoundary()
    {
        $this->configuration->setBoundary($boundary = 'foo');

        $this->assertSame($boundary, $this->configuration->getBoundary());
    }

    public function testSetTimeout()
    {
        $this->configuration->setTimeout($timeout = 2.5);

        $this->assertSame($timeout, $this->configuration->getTimeout());
    }

    public function testSetUserAgent()
    {
        $this->configuration->setUserAgent($userAgent = 'foo');

        $this->assertSame($userAgent, $this->configuration->getUserAgent());
    }

    public function testSetBaseUri()
    {
        $this->configuration->setBaseUri($baseUri = 'http://egeloen.fr/');

        $this->assertTrue($this->configuration->hasBaseUri());
        $this->assertSame($baseUri, (string) $this->configuration->getBaseUri());
    }

    /**
     * Creates a message factory mock
     *
     * @return MessageFactoryInterface|\PHPUnit_Framework_MockObject_MockObject The message factory mock.
     */
    private function createMessageFactoryMock()
    {
        return $this->getMock('Http\Adapter\Message\MessageFactoryInterface');
    }
}
