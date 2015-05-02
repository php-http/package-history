<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Tests\Message;

use Http\Adapter\Message\Request;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->request = new Request();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->request);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf('Psr\Http\Message\RequestInterface', $this->request);
        $this->assertInstanceOf('Http\Adapter\Message\RequestInterface', $this->request);
        $this->assertTrue(in_array(
            'Http\Adapter\Message\MessageTrait',
            class_uses('Http\Adapter\Message\Request')
        ));
    }

    public function testDefaultState()
    {
        $this->assertEmpty((string) $this->request->getUri());
        $this->assertNull($this->request->getMethod());
        $this->assertEmpty($this->request->getHeaders());
        $this->assertEmpty((string) $this->request->getBody());
        $this->assertEmpty($this->request->getParameters());
    }

    public function testInitialState()
    {
        $this->request = new Request(
            $uri = 'http://php-http.org/',
            $method = Request::METHOD_POST,
            $body = $this->getMock('Psr\Http\Message\StreamInterface'),
            $headers = ['foo' => ['bar']],
            $parameters = ['baz' => 'bat']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($uri, (string) $this->request->getUri());
        $this->assertSame($method, $this->request->getMethod());
        $this->assertSame($headers, $this->request->getHeaders());
        $this->assertSame($body, $this->request->getBody());
        $this->assertSame($parameters, $this->request->getParameters());
    }
}
