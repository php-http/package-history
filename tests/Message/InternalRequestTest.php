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

use Http\Adapter\Core\Message\InternalRequest;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class InternalRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InternalRequest
     */
    private $internalRequest;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->internalRequest = new InternalRequest();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->internalRequest);
    }

    public function testInheritance()
    {
        $this->assertInstanceOf('Phly\Http\Request', $this->internalRequest);
        $this->assertInstanceOf('Http\Adapter\Message\InternalRequest', $this->internalRequest);
    }

    public function testDefaultState()
    {
        $this->assertNull($this->internalRequest->getMethod());
        $this->assertEmpty((string) $this->internalRequest->getUri());
        $this->assertEmpty($this->internalRequest->getHeaders());
        $this->assertEmpty((string) $this->internalRequest->getBody());
        $this->assertEmpty($this->internalRequest->getAllData());
        $this->assertEmpty($this->internalRequest->getFiles());
        $this->assertEmpty($this->internalRequest->getParameters());
    }

    public function testInitialState()
    {
        $this->internalRequest = new InternalRequest(
            $method = 'POST',
            $uri = 'http://php-http.org/',
            $headers = ['foo' => ['bar']],
            $body = 'php://memory',
            $data = ['baz' => 'bat'],
            $files = ['bot' => 'ban'],
            $parameters = ['bip' => 'pog']
        );

        $headers['Host'] = ['php-http.org'];

        $this->assertSame($method, $this->internalRequest->getMethod());
        $this->assertSame($uri, (string) $this->internalRequest->getUri());
        $this->assertSame($headers, $this->internalRequest->getHeaders());
        $this->assertEmpty((string) $this->internalRequest->getBody());
        $this->assertSame($data, $this->internalRequest->getAllData());
        $this->assertSame($files, $this->internalRequest->getFiles());
        $this->assertSame($parameters, $this->internalRequest->getParameters());
    }

    public function testWithData()
    {
        $internalRequest = $this->internalRequest->withData($name = 'foo', 'bar');
        $internalRequest = $internalRequest->withData($name, $value = 'baz');

        $this->assertNotSame($internalRequest, $this->internalRequest);
        $this->assertTrue($internalRequest->hasData($name));
        $this->assertSame($value, $internalRequest->getData($name));
        $this->assertSame([$name => $value], $internalRequest->getAllData());
    }

    public function testWithAddedData()
    {
        $internalRequest = $this->internalRequest->withAddedData($name = 'foo', $value1 = 'bar');
        $internalRequest = $internalRequest->withAddedData($name, $value2 = 'baz');

        $this->assertNotSame($internalRequest, $this->internalRequest);
        $this->assertTrue($internalRequest->hasData($name));
        $this->assertSame([$value1, $value2], $internalRequest->getData($name));
        $this->assertSame([$name => [$value1, $value2]], $internalRequest->getAllData());
    }

    public function testWithoutData()
    {
        $internalRequest = $this->internalRequest->withData($name = 'foo', 'bar');
        $internalRequest = $internalRequest->withoutData($name);

        $this->assertNotSame($internalRequest, $this->internalRequest);
        $this->assertFalse($internalRequest->hasData($name));
        $this->assertNull($internalRequest->getData($name));
        $this->assertEmpty($internalRequest->getAllData());
    }

    public function testWithFile()
    {
        $internalRequest = $this->internalRequest->withFile($name = 'foo', 'bar');
        $internalRequest = $internalRequest->withFile($name, $value = 'baz');

        $this->assertNotSame($internalRequest, $this->internalRequest);
        $this->assertTrue($internalRequest->hasFile($name));
        $this->assertSame($value, $internalRequest->getFile($name));
        $this->assertSame([$name => $value], $internalRequest->getFiles());
    }

    public function testWithAddedFile()
    {
        $internalRequest = $this->internalRequest->withAddedFile($name = 'foo', $value1 = 'bar');
        $internalRequest = $internalRequest->withAddedFile($name, $value2 = 'baz');

        $this->assertNotSame($internalRequest, $this->internalRequest);
        $this->assertTrue($internalRequest->hasFile($name));
        $this->assertSame([$value1, $value2], $internalRequest->getFile($name));
        $this->assertSame([$name => [$value1, $value2]], $internalRequest->getFiles());
    }

    public function testWithoutFile()
    {
        $internalRequest = $this->internalRequest->withFile($name = 'foo', 'bar');
        $internalRequest = $internalRequest->withoutFile($name);

        $this->assertNotSame($internalRequest, $this->internalRequest);
        $this->assertFalse($internalRequest->hasFile($name));
        $this->assertNull($internalRequest->getFile($name));
        $this->assertEmpty($internalRequest->getFiles());
    }
}
