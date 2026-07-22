# Waxum PHP Client for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bayurifkialghifari/waxum-php-client.svg?style=flat-square)](https://packagist.org/packages/bayurifkialghifari/waxum-php-client)
[![Tests](https://img.shields.io/github/actions/workflow/status/bayurifkialghifari/waxum-php-client/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bayurifkialghifari/waxum-php-client/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bayurifkialghifari/waxum-php-client.svg?style=flat-square)](https://packagist.org/packages/bayurifkialghifari/waxum-php-client)

A Laravel PHP client library for the [Waxum WhatsApp API Gateway](https://waxum.karuhundeveloper.com/api-docs/openapi.json). Provides a clean, modular interface to interact with WhatsApp through your Waxum server instance.

## Features

- 🏗️ **Modular Architecture** — Organized by functionality: `session`, `message`, `group`, `contacts`, `blast`, `calls`, `chatstate`, `media`, `newsletter`, `nats`, `scheduler`, `presence`, `privacy`, `status`, `blocking`, `operations`, `mex`, `webhook`
- 📦 **PHP DTOs** — Strongly typed Data Transfer Objects for requests and responses across all endpoints
- 🔗 **Laravel Integration** — Service provider, facade (`WaxumApi`), and config file included
- ⚙️ **Configurable** — Set `base_url` and `token` via `.env` or config file

## Requirements

- PHP >= 8.2
- Laravel / `illuminate/support` >= 12.0

## Installation

```bash
composer require bayurifkialghifari/waxum-php-client
```

Publish the config file:

```bash
php artisan vendor:publish --tag="waxum-config"
```

## Configuration

Add to your `.env`:

```env
WAXUM_BASE_URL=http://localhost:3451
WAXUM_TOKEN=your-bearer-token
```

Published config (`config/waxum.php`):

```php
return [
    'base_url' => env('WAXUM_BASE_URL', 'http://localhost:3451'),
    'token'    => env('WAXUM_TOKEN'),
];
```

## Quick Start

### Using DTO Objects (Recommended)

```php
use Bayurifkialghifari\WaxumApi\Facades\WaxumApi;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendTextRequest;

// Create a WhatsApp session using DTO
$session = WaxumApi::session()->create(new CreateSessionRequest(
    name: 'Support Session',
));
echo $session->id;

// Send a text message using DTO
$response = WaxumApi::message()->sendText('session-id-123', new SendTextRequest(
    to: '628123456789@s.whatsapp.net',
    text: 'Hello from Waxum PHP Client! 👋',
));

echo $response->messageId; // Typed property from SendResponse DTO
```

### Using Associative Arrays

```php
// Arrays are also supported for quick calls
$response = WaxumApi::message()->sendText('session-id-123', [
    'to' => '628123456789@s.whatsapp.net',
    'text' => 'Hello from array request!',
]);
```

---

## API Reference & DTO Usage

### 📱 Session (`WaxumApi::session()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\ConnectRequest;

// Create session
$session = WaxumApi::session()->create(new CreateSessionRequest(name: 'My Session'));
echo $session->id;

// Connect session
$result = WaxumApi::session()->connect('session-123', new ConnectRequest(subscribe: ['Message']));
echo $result->message;

// Get status
$status = WaxumApi::session()->getStatus('session-123');
echo $status->isLoggedIn; // bool
```

### 💬 Messages (`WaxumApi::message()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendTextRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendImageRequest;

// Send text
$response = WaxumApi::message()->sendText('session-123', new SendTextRequest(
    to: '628123456789@s.whatsapp.net',
    text: 'Hello World!',
));
echo $response->messageId;

// Send image
$imageResponse = WaxumApi::message()->sendImage('session-123', new SendImageRequest(
    to: '628123456789@s.whatsapp.net',
    image: 'https://example.com/image.jpg',
    caption: 'Awesome picture',
));
```

### 👥 Groups (`WaxumApi::group()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Group\CreateGroupRequest;

// Create group
$group = WaxumApi::group()->create('session-123', new CreateGroupRequest(
    subject: 'Development Team',
    participants: ['628123456789@s.whatsapp.net'],
));
```

### 🚀 Blast Jobs (`WaxumApi::blast()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Blast\CreateBlastRequest;

// Create blast job
$blast = WaxumApi::blast()->create('session-123', new CreateBlastRequest(
    name: 'Promo Blast',
    recipients: ['628123456789@s.whatsapp.net'],
    message: 'Check out our latest offer!',
));
```

### 🌐 Webhooks (`WaxumApi::webhook()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\RegisterWebhookRequest;

// Register webhook
$webhook = WaxumApi::webhook()->register('session-123', new RegisterWebhookRequest(
    url: 'https://example.com/webhook',
    events: ['message', 'presence'],
));
```

---

## Testing

```bash
composer test
```

## Code Formatting

```bash
composer format
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
