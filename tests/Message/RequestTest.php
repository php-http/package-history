<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Core\Tests\Message;

use Http\Adapter\Core\Message\Request;

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
            'Http\Adapter\Core\Message\MessageTrait',
            class_uses('Http\Adapter\Core\Message\Request')
        ));
    }

    public function testDefaultState()
    {
        $this->assertNull($this->request->getMethod());
        $this->assertEmpty((string) $this->request->getUri());
        $this->assertEmpty($this->request->getHeaders());
        $this->assertEmpty((string) $this->request->getBody());
        $this->assertEmpty($this->request->getParameters());
    }

    public function testInitialState()
    {
        $this->request = new Request(
            $method = Request::METHOD_POST,
            $uri = 'http://php-http.org/',
            $headers = ['foo' => ['bar']],
            $body = $this->getMock('Psr\Http\Message\StreamInterface'),
            $parameters = ['baz' => 'bat']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($method, $this->request->getMethod());
        $this->assertSame($uri, (string) $this->request->getUri());
        $this->assertSame($headers, $this->request->getHeaders());
        $this->assertSame($body, $this->request->getBody());
        $this->assertSame($parameters, $this->request->getParameters());
    }
}
