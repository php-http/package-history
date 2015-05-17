<?php

namespace spec\Http\Adapter\Core;

use Http\Adapter\Core\CoreHttpAdapter;
use Http\Adapter\Message\InternalRequest;
use Http\Adapter\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CoreHttpAdapterSpec extends ObjectBehavior
{
    public function let(MessageFactory $messageFactory)
    {
        $this->beAnInstanceOf('spec\Http\Adapter\Core\CoreHttpAdapterStub', [['protocolVersion' => '1.1'], $messageFactory]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Adapter\Core\CoreHttpAdapter');
    }

    function it_is_message_factory_aware(MessageFactory $messageFactory, MessageFactory $anotherMessageFactory)
    {
        $this->shouldImplement('Http\Adapter\Message\MessageFactoryAware');

        $this->getMessageFactory()->shouldReturn($messageFactory);
        $this->setMessageFactory($anotherMessageFactory);
        $this->getMessageFactory()->shouldReturn($anotherMessageFactory);
    }

    function it_is_configurable()
    {
        $this->shouldImplement('Http\Adapter\Configurable');

        $this->getOption('protocolVersion')->shouldReturn('1.1');
        $this->getOption('contentType')->shouldReturn(null);
        $this->hasOption('protocolVersion')->shouldReturn(true);
        $this->hasOption('contentType')->shouldReturn(false);
        $this->hasOptions()->shouldReturn(true);
        $this->setOption('contentType', 'application/xml');
        $this->getOption('contentType')->shouldReturn('application/xml');
        $this->hasOption('contentType')->shouldReturn(true);
        $this->setOptions(['contentType' => 'application/xml']);
        $this->getOptions()->shouldReturn(['contentType' => 'application/xml']);
    }

    function it_is_a_configurable_http_adapter(MessageFactory $messageFactory, InternalRequest $internalRequest, ResponseInterface $response)
    {
        $this->shouldImplement('Http\Adapter\ConfigurableHttpAdapter');

        $messageFactory->createInternalRequest(
            Argument::that(function($arg) { return in_array($arg, ['GET', 'HEAD', 'TRACE', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']); }),
            '/',
            '1.1',
            [], [], [], [],
            $this->getOptions()
        )->willReturn($internalRequest);
        $messageFactory->createResponse()->willReturn($response);

        $this->get('/')->shouldReturn($response);
        $this->head('/')->shouldReturn($response);
        $this->trace('/')->shouldReturn($response);
        $this->post('/')->shouldReturn($response);
        $this->put('/')->shouldReturn($response);
        $this->patch('/')->shouldReturn($response);
        $this->delete('/')->shouldReturn($response);
        $this->options('/')->shouldReturn($response);
        $this->send('GET', '/')->shouldReturn($response);
    }

    function it_throws_an_exception_when_both_stream_and_files_are_passed(StreamInterface $stream)
    {
        $this->shouldThrow('InvalidArgumentException')->duringSend('POST', '/', [], $stream, ['file']);
    }
}

class CoreHttpAdapterStub extends CoreHttpAdapter
{
    public function getName()
    {
        return 'core';
    }

    public function sendInternalRequest(InternalRequest $internalRequest)
    {
        return $this->messageFactory->createResponse();
    }
}
