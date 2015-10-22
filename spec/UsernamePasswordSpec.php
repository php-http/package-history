<?php

namespace spec\Http\Authentication;

use Http\Authentication\UsernamePassword;
use PhpSpec\ObjectBehavior;

class UsernamePasswordSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(
            'spec\Http\Authentication\UsernamePasswordStub',
            [
                'john.doe',
                'secret',
            ]
        );
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
}

class UsernamePasswordStub
{
    use UsernamePassword;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}
