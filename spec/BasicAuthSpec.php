<?php

namespace spec\Http\Authentication;

use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;

class BasicAuthSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('john.doe', 'secret');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Authentication\BasicAuth');
    }

    function it_is_an_authentication()
    {
        $this->shouldImplement('Http\Authentication\Authentication');
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

    function it_authenticates_a_request(RequestInterface $request, RequestInterface $newRequest)
    {
        $request->withHeader('Authorization', 'Basic '.base64_encode('john.doe:secret'))->willReturn($newRequest);

        $this->authenticate($request)->shouldReturn($newRequest);
    }
}
