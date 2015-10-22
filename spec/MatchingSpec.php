<?php

namespace spec\Http\Authentication;

use Http\Authentication\Authentication;
use Psr\Http\Message\RequestInterface;
use PhpSpec\ObjectBehavior;

class MatchingSpec extends ObjectBehavior
{
    private $matcher;

    function let(Authentication $authentication)
    {
        $this->matcher = function($request) { return true; };

        $this->beConstructedWith($authentication, $this->matcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Authentication\Matching');
    }

    function it_has_an_authentication(Authentication $authentication)
    {
        $this->getAuthentication()->shouldReturn($authentication);
    }

    function it_accepts_an_authentication(Authentication $anotherAuthentication)
    {
        $this->setAuthentication($anotherAuthentication);

        $this->getAuthentication()->shouldReturn($anotherAuthentication);
    }

    function it_has_a_matcher()
    {
        $this->getMatcher()->shouldReturn($this->matcher);
    }

    function it_accepts_a_matcher()
    {
        $matcher = function($request) { return false; };

        $this->setMatcher($matcher);

        $this->getMatcher()->shouldReturn($matcher);
    }

    function it_authenticates_a_request(Authentication $authentication, RequestInterface $request, RequestInterface $newRequest)
    {
        $authentication->authenticate($request)->willReturn($newRequest);

        $this->authenticate($request)->shouldReturn($newRequest);
    }

    function it_does_not_authenticate_a_request(Authentication $authentication, RequestInterface $request)
    {
        $matcher = function($request) { return false; };

        $this->setMatcher($matcher);

        $authentication->authenticate($request)->shouldNotBeCalled();

        $this->authenticate($request)->shouldReturn($request);
    }

    function it_creates_a_matcher_from_url(Authentication $authentication)
    {
        $this->createUrlMatcher($authentication, 'url')->shouldHaveType('Http\Authentication\Matching');
    }
}
