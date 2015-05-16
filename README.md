# Message Decorator

[![Latest Version](https://img.shields.io/github/release/php-http/message-decorator.svg?style=flat-square)](https://github.com/php-http/message-decorator/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/php-http/message-decorator.svg?style=flat-square)](https://travis-ci.org/php-http/message-decorator)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-http/message-decorator.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/message-decorator)
[![Quality Score](https://img.shields.io/scrutinizer/g/php-http/message-decorator.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-http/message-decorator)
[![HHVM Status](https://img.shields.io/hhvm/php-http/message-decorator.svg?style=flat-square)](http://hhvm.h4cc.de/package/php-http/message-decorator)
[![Total Downloads](https://img.shields.io/packagist/dt/php-http/message-decorator.svg?style=flat-square)](https://packagist.org/packages/php-http/message-decorator)

**Decorators for PSR-7 HTTP Messages.**


## Install

Via Composer

``` bash
$ composer require php-http/message-decorator
```


## Usage

This package provides an easy way to decorate PSR-7 messages. While the decorator classes themselves are not abstract, they only make sense when they are extended to add custom logic:

``` php
use Http\Message\RequestDecorator;

class MyRequestDecorator extends RequestDecorator
{
    public function isThisAPostRequest()
    {
        return $this->getMethod() === 'POST';
    }
}

$request = new MyRequestDecorator($decoratedRequest);
```

If you override the constructor, make sure that you accept a message argument (either request or response):

``` php
use Http\Message\ResponseDecorator;
use Psr\Http\Message\ResponseInterface;

class MyResponseDecorator extends ResponseDecorator
{
    public function __construct(ResponseInterface $message)
    {
        parent::__construct($message);

        // some custom logic
    }
}
```

The decorated messages are stored under a private `$message` property. To ease acces to this property, there is a public `getMessage` method available in both decorators.

``` php
use Http\Message\ResponseDecorator;

class MyResponseDecorator extends ResponseDecorator
{
    public function stringifyResponse()
    {
        return (string) $this->getMessage()->getBody();
    }
}
```

Since the underlying message is immutable as well, there is no risk that you can alter it, so exposing it is safe. However the decorators are completely transparent, so there are rare cases when you want to access the original message.


**Note:** Hence the immutability of both the decorators and the underlying messages, every writting operation causes two object cloning which definitely mean a bigger performance hit.


## Testing

``` bash
$ phpspec run
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
