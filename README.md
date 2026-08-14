# Waxum PHP Client for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bayurifkialghifari/waxum-php-client.svg?style=flat-square)](https://packagist.org/packages/bayurifkialghifari/waxum-php-client)
[![Tests](https://img.shields.io/github/actions/workflow/status/bayurifkialghifari/waxum-php-client/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bayurifkialghifari/waxum-php-client/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bayurifkialghifari/waxum-php-client.svg?style=flat-square)](https://packagist.org/packages/bayurifkialghifari/waxum-php-client)

A Laravel PHP client library for the [Waxum WhatsApp API Gateway](https://github.com/imtaqin/waxum). Provides a clean, modular interface to interact with WhatsApp through your Waxum server instance.

## Features

- 🏗️ **Modular Architecture** — Organized by functionality: `session`, `message`, `group`, `contacts`, `blast`, `calls`, `chatstate`, `media`, `newsletter`, `nats`, `scheduler`, `presence`, `privacy`, `status`, `blocking`, `operations`, `mex`, `webhook`, `fleet`, `tokens`, `tags`, `labels`, `business`, `bots`
- 📦 **PHP DTOs** — Strongly typed Data Transfer Objects for requests and responses across all endpoints
- 🔐 **Webhook Signature Verification** — `WebhookSignature` implements the gateway's v2 HMAC scheme with replay protection
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
echo $status->socketAlive; // bool
echo $status->paused;      // bool

// Pause / resume event processing without disconnecting
WaxumApi::session()->pause('session-123');
WaxumApi::session()->resume('session-123');

// Force an app-state resync
use Bayurifkialghifari\WaxumApi\DTOs\Session\AppStateResyncMode;

WaxumApi::session()->resyncAppState('session-123', ['critical_block'], AppStateResyncMode::SNAPSHOT);

// Fleet-wide operations
WaxumApi::session()->disconnectAll();
WaxumApi::session()->reconnectAll();
$hits = WaxumApi::session()->search('support');

// Export / import a session (ZIP)
WaxumApi::session()->export('session-123')->saveAs(storage_path('backup.zip'));
WaxumApi::session()->import('session-123', storage_path('backup.zip'));
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

### 📎 Media (`WaxumApi::media()`)

Uploads are sent as `multipart/form-data` (100 MB server limit).

```php
$upload = WaxumApi::media()->upload(
    sessionId: 'session-123',
    filePath: storage_path('app/photo.jpg'),
    mediaType: 'image',
    mimetype: 'image/jpeg',
);
echo $upload->url;
```

### 🌐 Webhooks (`WaxumApi::webhook()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\RegisterWebhookRequest;

// Register webhook
$webhook = WaxumApi::webhook()->register('session-123', new RegisterWebhookRequest(
    url: 'https://example.com/webhook',
    events: ['message', 'presence'],
));

// Dead-letter queue: inspect and replay failed deliveries
$dlq = WaxumApi::webhook()->listDlq('session-123');
WaxumApi::webhook()->replayDlq('session-123', $dlq->entries[0]->id);
```

### 🔐 Verifying Webhook Signatures

The gateway signs each delivery with `HMAC-SHA256("{timestamp}.{raw_body}")`
using the secret you registered, sending it as
`X-Webhook-Signature: sha256=<hex>` alongside `X-Webhook-Timestamp`.
`WebhookSignature` verifies it in constant time and rejects timestamps
outside a 300-second window (replay protection).

```php
use Bayurifkialghifari\WaxumApi\WebhookSignature;

public function handle(Request $request)
{
    if (! WebhookSignature::fromRequest($request, config('services.waxum.webhook_secret'))) {
        abort(401);
    }

    // ... process $request->json()
}
```

Outside Laravel, or when you already hold the raw body:

```php
WebhookSignature::verify(
    rawBody: $rawBody,
    timestamp: $timestampHeader,
    signatureHeader: $signatureHeader,
    secret: $secret,
    toleranceSeconds: 300,
);
```

### 🛰️ Fleet (`WaxumApi::fleet()`)

```php
$info  = WaxumApi::fleet()->info();   // version + geo location
$stats = WaxumApi::fleet()->stats();  // session/webhook counters, uptime
$ready = WaxumApi::fleet()->ready();  // readiness probe with per-session state

WaxumApi::fleet()->reenableAllWebhooks(); // close all open circuit breakers
```

### 🔑 Tokens (`WaxumApi::tokens()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Token\MintTokenRequest;

$token = WaxumApi::tokens()->mint(new MintTokenRequest(
    name: 'blast-worker',
    sessionIds: ['session-123'],
    expiresInHours: 720,
));
echo $token->token;
$all   = WaxumApi::tokens()->list();
WaxumApi::tokens()->revoke($token->id);
```

### 🏷️ Tags (`WaxumApi::tags()`)

```php
WaxumApi::tags()->add('session-123', 'production');
WaxumApi::tags()->setTags('session-123', ['production', 'billing']);
$tags = WaxumApi::tags()->forSession('session-123');
```

### 🔖 Labels (`WaxumApi::labels()`)

```php
use Bayurifkialghifari\WaxumApi\DTOs\Labels\CreateLabelRequest;

WaxumApi::labels()->createLabel('session-123', new CreateLabelRequest(
    labelId: '1',
    name: 'Lead',
    colorId: 3,
));

WaxumApi::labels()->addChatToLabel('session-123', '1', '628123456789@s.whatsapp.net');
```

### 🏬 Business (`WaxumApi::business()`)

`$jid` is required by the server on catalog/collection/order calls.

```php
$catalog = WaxumApi::business()->catalog('session-123', '628123456789@s.whatsapp.net');
```

### 🤖 Bots (`WaxumApi::bots()`)

```php
$bots    = WaxumApi::bots()->bots('session-123');
$capping = WaxumApi::bots()->capping('session-123');
```

---

## Upgrading from 1.x to 2.0

See [CHANGELOG.md](CHANGELOG.md) for the full list. Three things to check:

1. **`media()->upload()`** now takes a file path instead of an array, and
   `$token` moved to the 5th parameter:

   ```php
   // 1.x (never worked against the server)
   WaxumApi::media()->upload($sessionId, ['file' => $base64], $token);

   // 2.0
   WaxumApi::media()->upload($sessionId, '/path/to/file.jpg', 'image', 'image/jpeg', $token);
   ```

2. **`WebhookEventType::KEEP_ALIVE_TIMEOUT` was removed** — the gateway no
   longer emits it. Use `DISCONNECTED` or the new `STREAM_ERROR`.

3. **Construct DTOs with named arguments.** New properties were inserted into
   `SendTextRequest`, `SessionStatusResponse`, and `CreateSessionRequest`;
   positional construction will bind to the wrong properties.

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
