<?php

namespace spec\Http\Common\Message;

use PhpSpec\ObjectBehavior;

class MessageFactoryGuesserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Common\Message\MessageFactoryGuesser');
    }

    function it_registers_a_factory()
    {
        $this->reset();

        $this->register('test', 'spec\Http\Common\Message\TestClass', 'spec\Http\Common\Message\Factory');

        $this->unregister('guzzle');
        $this->unregister('diactoros');

        $this->guess()->shouldHaveType('spec\Http\Common\Message\Factory');
    }

    function it_guesses_guzzle_then_zend_by_default()
    {
        $this->reset();

        $this->guess()->shouldHaveType('Http\Common\Message\MessageFactory\GuzzleFactory');
        $this->unregister('guzzle');

        if (class_exists('Zend\Diactoros\Request')) {
            $this->guess()->shouldHaveType('Http\Common\Message\MessageFactory\DiactorosFactory');
        }
    }

    function it_throws_an_exception_when_no_message_factory_is_found()
    {
        $this->reset();

        $this->unregister('guzzle');
        $this->unregister('diactoros');

        $this->shouldThrow('RuntimeException')->duringGuess();
    }

    function reset()
    {
        $this->unregister('guzzle');
        $this->unregister('diactoros');
        $this->unregister('test');

        $this->register('guzzle', 'GuzzleHttp\Psr7\Request', 'Http\Common\Message\MessageFactory\GuzzleFactory');
        $this->register('diactoros', 'Zend\Diactoros\Request', 'Http\Common\Message\MessageFactory\DiactorosFactory');
    }
}

class TestClass {}
class Factory {}
