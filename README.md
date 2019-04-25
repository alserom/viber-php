# PHP SDK for Viber REST API [![Latest Stable Version](https://img.shields.io/packagist/v/alserom/viber-php.svg?label=stable&style=flat-square)](https://packagist.org/packages/alserom/viber-php) [![Latest Unstable Version](https://img.shields.io/packagist/vpre/alserom/viber-php.svg?label=unstable&style=flat-square)](https://packagist.org/packages/alserom/viber-php#dev-master)

[![Build Status](https://img.shields.io/travis/alserom/viber-php.svg?style=flat-square)](https://travis-ci.org/alserom/viber-php)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/alserom/viber-php.svg?style=flat-square)](https://www.php.net/supported-versions.php)
[![Coding Style](https://img.shields.io/badge/code%20style-PSR--12-informational.svg?style=flat-square)](https://github.com/php-fig/fig-standards/blob/master/proposed/extended-coding-style-guide.md)
[![Software License](https://img.shields.io/github/license/alserom/viber-php.svg?style=flat-square)](LICENSE)

Use this library to develop a bot for the Viber platform or simple work with [Viber REST API](https://developers.viber.com/docs/api/rest-bot-api/).

> Note: For work with Viber API, you must have an authentication token. Go to [partners.viber.com](https://partners.viber.com), create bot account and get token.

## Installation

```bash
composer require alserom/viber-php
```

For properly work with this package you do also need to install a PSR-17 request/response factory and PSR-18 HTTP Client.  
You can find packages of these implementations here:
- [List of PSR-17 implementations](https://packagist.org/providers/psr/http-factory-implementation)
- [List of PSR-18 implementations](https://packagist.org/providers/psr/http-client-implementation)

Example:

```bash
composer require nyholm/psr7 kriswallsmith/buzz
```

## Usage

This page will just show you the basics. For advanced usage, please read the full [documentation](docs/README.md).

If you want to quickly try this library on practice, you can use the code from repository [viber-bot-examples](https://github.com/alserom/viber-bot-examples).

### Create objects

```php
// Any PSR-17 implementation. In this case, we use 'nyholm/psr7' package.
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

// Any PSR-18 implementation. In this case, we use 'kriswallsmith/buzz' package.
$psr18Client = new \Buzz\Client\Curl($psr17Factory);

/* A simple object for getting all PSR-17 factories.
 * If you have an object which implements all PSR-17 interfaces, you can use a static method. E.g:
 * $psr17 = \Alserom\Viber\Psr17::useForAll($psr17Factory);
 */
$psr17 = new \Alserom\Viber\Psr17(
    $psr17Factory, // \Psr\Http\Message\RequestFactoryInterface
    $psr17Factory, // \Psr\Http\Message\ResponseFactoryInterface
    $psr17Factory, // \Psr\Http\Message\ServerRequestFactoryInterface
    $psr17Factory, // \Psr\Http\Message\StreamFactoryInterface
    $psr17Factory, // \Psr\Http\Message\UploadedFileFactoryInterface
    $psr17Factory  // \Psr\Http\Message\UriFactoryInterface
);

$token = 'YOUR-AUTHENTICATION-TOKEN';

/* An object for work with Viber API.
 * As a fourth argument, you can pass an array of options. See the full documentation for more info.
 */
$api = new \Alserom\Viber\Api($token, $psr17, $psr18Client);

/* An object for creating a logic of Viber bot.
 * As a second argument, you can pass an array of options. See the full documentation for more info.
 */
$bot = new \Alserom\Viber\Bot($api);
```

### Setting a Webhook

```php
$url = 'YOUR-HTTPS-WEBHOOK-URL';
$webhook = new \Alserom\Viber\Entity\Webhook($url);

// If you want that your bot receives user names instead of placeholder values.
// $webhook->setSendName(true);

// If you want that your bot receives user photos instead of placeholder values.
// $webhook->setSendPhoto(true); 

// If you want to filter which events would get a callback for.
// $webhook->setEventTypes(['delivered', 'seen', 'conversation_started']); 

$api->setWebhook($webhook);
```

### Sending message

Build a message from scratch:
```php
$message = new \Alserom\Viber\Message('text');
$message
    ->setText('Hello World!')
    ->setTo(new \Alserom\Viber\Entity\User('USER-IDENTIFIER-HERE'));

// $response is a \Alserom\Viber\Response\Type\SendMessageResponse object.
$response = $api->sendMessage($message);
```

Or use prepared entity:
```php
$entity = new \Alserom\Viber\Entity\Message\Text();
$entity->setText('Hello World!');

$message = new \Alserom\Viber\Message();
$message->setTo(new \Alserom\Viber\Entity\User('USER-IDENTIFIER-HERE'));
$message->setEntity($entity);

$response = $api->sendMessage($message);
```

### Registering events (Viber callbacks) handlers

```php
$handler = function (\Alserom\Viber\Event\EventInterface $event, \Alserom\Viber\Api $api) {
    // Your logic here
};

$bot->on('message', $handler);

// Or use helper methods
$bot->onMessage($handler);
```

### Handling Viber callbacks

Viber expecting you to return a response with HTTP status code 200 for be sure that callback was delivered.
Also, once a `conversation_started` callback is received you can send a welcome message to the user by returning a response with a prepared message.  
This package took care of this. The method `\Alserom\Viber\Bot :: handle` will return the generated response, which remains simply to emit.

You can use [`nyholm/psr7-server`](https://github.com/Nyholm/psr7-server) package or any alternative to create server requests from PHP superglobals.  
You can use [`zendframework/zend-httphandlerrunner`](https://github.com/zendframework/zend-httphandlerrunner) package or any alternative to emitting PSR-7 responses.

```bash
composer require nyholm/psr7-server zendframework/zend-httphandlerrunner
```

```php
$serverRequestCreator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // \Psr\Http\Message\ServerRequestFactoryInterface
    $psr17Factory, // \Psr\Http\Message\UriFactoryInterface
    $psr17Factory, // \Psr\Http\Message\UploadedFileFactoryInterface
    $psr17Factory  // \Psr\Http\Message\StreamFactoryInterface
);

$serverRequest = $serverRequestCreator->fromGlobals();

// $response is a PSR-7 Response object
$response = $bot->handle($serverRequest);

$emitter = new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
$emitter->emit($response);
```

## TODO list

- Write documentation
- Create to more tests
- See `@TODO` tags in the code

## Contributing

Pull requests are welcome.

Before you make a PR, be sure that your code is suited to be merged. Just run several scripts:
```bash
composer test
composer check-code
composer check-style
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## See more

- [Viber REST API](https://developers.viber.com/docs/api/rest-bot-api/)
- [Viber Node.JS Bot API](https://viber.github.io/docs/api/nodejs-bot-api/)
- [Viber Python Bot API](https://viber.github.io/docs/api/python-bot-api/)
- [Tools, boilerplates and more from Viber API's open-source contributors. ](https://viber.github.io/community/)
