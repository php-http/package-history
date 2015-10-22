<?php

namespace spec\Http\Authentication;

use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;

class WsseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('john.doe', 'secret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Authentication\Wsse');
    }

    function it_has_a_username()
    {
        $this->getUsername()->shouldReturn('john.doe');
    }

    function it_accepts_a_username()
    {
        $this->setUsername('jane.doe');

        $this->getUsername()->shouldReturn('jane.doe');
    }

    function it_has_a_password()
    {
        $this->getPassword()->shouldReturn('secret');
    }

    function it_accepts_a_password()
    {
        $this->setPassword('very_secret');

        $this->getPassword()->shouldReturn('very_secret');
    }

    function it_authenticates_a_request(
        RequestInterface $request,
        RequestInterface $newRequest,
        RequestInterface $newerRequest
    ) {
        $request->withHeader('Authorization', 'WSSE profile="UsernameToken"')->willReturn($newRequest);
        $newRequest->withHeader('X-WSSE', Argument::that(function($arg) {
            return preg_match('/UsernameToken Username=".*", PasswordDigest=".*", Nonce=".*", Created=".*"/', $arg);
        }))->willReturn($newerRequest);

        $this->authenticate($request)->shouldReturn($newerRequest);
    }
}
