<?php

namespace spec\Http\Cookie;

use Http\Cookie\Cookie;
use PhpSpec\ObjectBehavior;

class CookieSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('name', 'value', 0, null, null, false, false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Cookie\Cookie');
    }

    function it_throws_an_exception_when_the_name_contains_invalid_character()
    {
        for ($i = 0; $i < 128; $i++) {
            $name = chr($i);

            if (preg_match('/[\x00-\x20]|\x22|[\x28-\x29]|\x2c|\x2f|[\x3a-\x40]|[\x5b-\x5d]|\x7b|\x7d|\x7f/', $name)) {
                $expectation = $this->shouldThrow('InvalidArgumentException');
            } else {
                $expectation = $this->shouldNotThrow('InvalidArgumentException');
            }

            $expectation->during('__construct', [$name]);
        }
    }

    function it_throws_an_expection_when_name_is_empty()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['']);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('name');
    }

    function it_has_a_value()
    {
        $this->getValue()->shouldReturn('value');
        $this->hasValue()->shouldReturn(true);
    }

    function it_has_an_invalid_max_age_time()
    {
        $this->getMaxAge()->shouldReturn(0);
        $this->getExpires()->shouldHaveType('DateTime');
        $this->hasMaxAge()->shouldReturn(true);
        $this->hasExpires()->shouldReturn(true);
        $this->isExpired()->shouldReturn(true);
    }

    function it_has_a_max_age_time()
    {
        $this->beConstructedWith('name', 'value', 10);

        $this->getMaxAge()->shouldReturn(10);
        $this->getExpires()->shouldHaveType('DateTime');
        $this->hasMaxAge()->shouldReturn(true);
        $this->hasExpires()->shouldReturn(true);
        $this->isExpired()->shouldReturn(false);
    }

    function it_has_an_expiration_time()
    {
        $expires = new \DateTime('+10 seconds');

        $this->beConstructedWith('name', 'value', $expires);

        $this->getMaxAge()->shouldReturn(null);
        $this->getExpires()->shouldReturn($expires);
        $this->hasMaxAge()->shouldReturn(false);
        $this->hasExpires()->shouldReturn(true);
        $this->isExpired()->shouldReturn(false);
    }

    function it_is_expired()
    {
        $this->beConstructedWith('name', 'value', -10);

        $this->getMaxAge()->shouldReturn(-10);
        $this->getExpires()->shouldHaveType('DateTime');
        $this->hasMaxAge()->shouldReturn(true);
        $this->hasExpires()->shouldReturn(true);
        $this->isExpired()->shouldReturn(true);
    }

    function it_has_an_infinite_expiration_time()
    {
        $this->beConstructedWith('name', 'value', null);

        $this->getMaxAge()->shouldReturn(null);
        $this->getExpires()->shouldReturn(null);
        $this->hasMaxAge()->shouldReturn(false);
        $this->hasExpires()->shouldReturn(false);
        $this->isExpired()->shouldReturn(false);
    }

    function it_has_a_domain()
    {
        $this->getDomain()->shouldReturn(null);
        $this->hasDomain()->shouldReturn(false);
    }

    function it_has_a_valid_domain()
    {
        $this->beConstructedWith('name', 'value', null, '.PhP-hTtP.oRg');

        $this->getDomain()->shouldReturn('php-http.org');
        $this->hasDomain()->shouldReturn(true);
    }

    function it_matches_a_domain()
    {
        $this->beConstructedWith('name', 'value', null, 'php-http.org');

        $this->matchDomain('PhP-hTtP.oRg')->shouldReturn(true);
        $this->matchDomain('127.0.0.1')->shouldReturn(false);
        $this->matchDomain('wWw.PhP-hTtP.oRg')->shouldReturn(true);
    }

    function it_has_a_path()
    {
        $this->getPath()->shouldReturn('/');
    }

    function it_matches_a_path()
    {
        $this->beConstructedWith('name', 'value', null, null, '/path/to/somewhere');

        $this->matchPath('/path/to/somewhere')->shouldReturn(true);
        $this->matchPath('/path/to/somewhereelse')->shouldReturn(false);
    }

    function it_can_be_secure()
    {
        $this->isSecure()->shouldReturn(false);
    }

    function it_can_be_http_only()
    {
        $this->isHttpOnly()->shouldReturn(false);
    }

    function it_matches_another_cookies()
    {
        $this->beConstructedWith('name', 'value', null, 'php-http.org');

        $matches = new Cookie('name', 'value2', null, 'php-http.org');
        $notMatches = new Cookie('anotherName', 'value2', null, 'php-http.org');

        $this->match($matches)->shouldReturn(true);
        $this->match($notMatches)->shouldReturn(false);
    }
}
