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

use Http\Adapter\Message\Response;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    private $response;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->response = new Response();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->response);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $this->response);
        $this->assertInstanceOf('Http\Adapter\Message\ResponseInterface', $this->response);
        $this->assertTrue(in_array(
            'Http\Adapter\Message\MessageTrait',
            class_uses('Http\Adapter\Message\Response')
        ));
    }

    public function testDefaultState()
    {
        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertEmpty($this->response->getHeaders());
        $this->assertEmpty((string) $this->response->getBody());
        $this->assertEmpty($this->response->getParameters());
    }

    public function testInitialState()
    {
        $this->response = new Response(
            $statusCode = 302,
            $headers = ['foo' => ['bar']],
            $body = $this->getMock('Psr\Http\Message\StreamInterface'),
            $parameters = ['baz' => 'bat']
        );

        $this->assertSame($statusCode, $this->response->getStatusCode());
        $this->assertSame($headers, $this->response->getHeaders());
        $this->assertSame($body, $this->response->getBody());
        $this->assertSame($parameters, $this->response->getParameters());
    }
}
