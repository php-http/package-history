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

use Http\Adapter\Message\MessageFactory;
use Http\Adapter\Message\RequestInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->messageFactory = new MessageFactory();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->messageFactory);
    }

    public function testInitialState()
    {
        $this->assertFalse($this->messageFactory->hasBaseUri());
    }

    public function testInheritance()
    {
        $this->assertInstanceOf('Http\Adapter\Message\MessageFactoryInterface', $this->messageFactory);
    }

    public function testCreateRequest()
    {
        $request = $this->messageFactory->createRequest($method = RequestInterface::METHOD_GET, $uri = 'http://php-http.org/');

        $this->assertInstanceOf('Http\Adapter\Message\Request', $request);
        $this->assertSame(RequestInterface::METHOD_GET, $request->getMethod());
        $this->assertSame($uri, (string) $request->getUri());
        $this->assertSame(['Host' => ['php-http.org']], $request->getHeaders());
        $this->assertEmpty((string) $request->getBody());
        $this->assertEmpty($request->getParameters());
    }

    public function testCreateRequestWithFullInformations()
    {
        $request = $this->messageFactory->createRequest(
            $method = RequestInterface::METHOD_POST,
            $uri = 'http://php-http.org/',
            $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_0,
            $headers = ['foo' => ['bar']],
            $body = $this->getMock('Psr\Http\Message\StreamInterface'),
            $parameters = ['baz' => 'bat']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($uri, (string) $request->getUri());
        $this->assertSame($protocolVersion, $request->getProtocolVersion());
        $this->assertSame($headers, $request->getHeaders());
        $this->assertSame($body, $request->getBody());
        $this->assertSame($parameters, $request->getParameters());
    }

    public function testCreateInternalRequest()
    {
        $internalRequest = $this->messageFactory->createInternalRequest($method = RequestInterface::METHOD_GET, $uri = 'http://php-http.org/');

        $this->assertInstanceOf('Http\Adapter\Message\InternalRequest', $internalRequest);
        $this->assertSame(RequestInterface::METHOD_GET, $internalRequest->getMethod());
        $this->assertSame($uri, (string) $internalRequest->getUri());
        $this->assertSame(RequestInterface::PROTOCOL_VERSION_1_1, $internalRequest->getProtocolVersion());
        $this->assertSame(['Host' => ['php-http.org']], $internalRequest->getHeaders());
        $this->assertEmpty((string) $internalRequest->getBody());
        $this->assertEmpty($internalRequest->getAllData());
        $this->assertEmpty($internalRequest->getFiles());
        $this->assertEmpty($internalRequest->getParameters());
    }

    public function testCreateInternalRequestWithArrayData()
    {
        $internalRequest = $this->messageFactory->createInternalRequest(
            $method = RequestInterface::METHOD_POST,
            $uri = 'http://php-http.org/',
            $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_0,
            $headers = ['foo' => ['bar']],
            $data = ['baz' => 'bat'],
            $files = ['bot' => 'ban'],
            $parameters = ['bip' => 'pog']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($method, $internalRequest->getMethod());
        $this->assertSame($uri, (string) $internalRequest->getUri());
        $this->assertSame($protocolVersion, $internalRequest->getProtocolVersion());
        $this->assertSame($headers, $internalRequest->getHeaders());
        $this->assertEmpty((string) $internalRequest->getBody());
        $this->assertSame($data, $internalRequest->getAllData());
        $this->assertSame($files, $internalRequest->getFiles());
        $this->assertSame($parameters, $internalRequest->getParameters());
    }

    public function testCreateInternalRequestWithStringData()
    {
        $internalRequest = $this->messageFactory->createInternalRequest(
            $method = RequestInterface::METHOD_POST,
            $uri = 'http://php-http.org/',
            $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_0,
            $headers = ['foo' => ['bar']],
            $data = 'baz=bat',
            $files = [],
            $parameters = ['bip' => 'pog']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($method, $internalRequest->getMethod());
        $this->assertSame($uri, (string) $internalRequest->getUri());
        $this->assertSame($protocolVersion, $internalRequest->getProtocolVersion());
        $this->assertSame($headers, $internalRequest->getHeaders());
        $this->assertSame($data, (string) $internalRequest->getBody());
        $this->assertEmpty($internalRequest->getAllData());
        $this->assertEmpty($internalRequest->getFiles());
        $this->assertSame($parameters, $internalRequest->getParameters());
    }

    public function testCreateInternalRequestWithResourceData()
    {
        $resource = fopen('php://memory', 'rw');
        fwrite($resource, $data = 'baz=bat');

        $internalRequest = $this->messageFactory->createInternalRequest(
            $method = RequestInterface::METHOD_POST,
            $uri = 'http://php-http.org/',
            $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_0,
            $headers = ['foo' => ['bar']],
            $resource,
            $files = [],
            $parameters = ['bip' => 'pog']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($method, $internalRequest->getMethod());
        $this->assertSame($uri, (string) $internalRequest->getUri());
        $this->assertSame($protocolVersion, $internalRequest->getProtocolVersion());
        $this->assertSame($headers, $internalRequest->getHeaders());
        $this->assertSame($data, (string) $internalRequest->getBody());
        $this->assertEmpty($internalRequest->getAllData());
        $this->assertEmpty($internalRequest->getFiles());
        $this->assertSame($parameters, $internalRequest->getParameters());
    }

    public function testCreateResponse()
    {
        $response = $this->messageFactory->createResponse();

        $this->assertInstanceOf('Http\Adapter\Message\Response', $response);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('OK', $response->getReasonPhrase());
        $this->assertEmpty($response->getHeaders());
        $this->assertEmpty((string) $response->getBody());
        $this->assertEmpty($response->getParameters());
    }

    public function testCreateResponseWithFullInformations()
    {
        $response = $this->messageFactory->createResponse(
            $statusCode = 404,
            $protocolVersion = RequestInterface::PROTOCOL_VERSION_1_0,
            $headers = ['foo' => ['bar']],
            $body = $this->getMock('Psr\Http\Message\StreamInterface'),
            $parameters = ['baz' => 'bat']
        );

        $this->assertSame($statusCode, $response->getStatusCode());
        $this->assertSame($protocolVersion, $response->getProtocolVersion());
        $this->assertSame($headers, $response->getHeaders());
        $this->assertSame($body, $response->getBody());
        $this->assertSame($parameters, $response->getParameters());
    }

    public function testSetBaseUri()
    {
        $this->messageFactory->setBaseUri($baseUri = 'http://php-http.org/');

        $this->assertTrue($this->messageFactory->hasBaseUri());
        $this->assertSame($baseUri, (string) $this->messageFactory->getBaseUri());
    }

    public function testCreateRequestWithBaseUri()
    {
        $this->messageFactory->setBaseUri($baseUri = 'http://php-http.org/');

        $request = $this->messageFactory->createRequest($method = RequestInterface::METHOD_GET, $uri = 'test');

        $this->assertInstanceOf('Http\Adapter\Message\Request', $request);
        $this->assertSame($baseUri.$uri, (string) $request->getUri());
    }

    public function testCreateInternalRequestWithBaseUri()
    {
        $this->messageFactory->setBaseUri($baseUri = 'http://php-http.org/');

        $request = $this->messageFactory->createInternalRequest($method = RequestInterface::METHOD_GET, $uri = 'test');

        $this->assertInstanceOf('Http\Adapter\Message\InternalRequest', $request);
        $this->assertSame($baseUri.$uri, (string) $request->getUri());
    }
}
