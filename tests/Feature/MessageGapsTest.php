<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SendResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Message\MessageSearchResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Message\SessionMessagesResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('sends a reaction', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/react' => Http::response([
            'message_id' => 'msg-1',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendReaction('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'message_id' => 'msg-0',
        'emoji' => '👍',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-1');
});

it('sends a cta url message', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/cta-url' => Http::response([
            'message_id' => 'msg-2',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendCtaUrl('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'text' => 'Check this out',
        'url' => 'https://example.com',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-2');
});

it('sends a quick reply message', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/quick-reply' => Http::response([
            'message_id' => 'msg-3',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendQuickReply('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'text' => 'Pick one',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-3');
});

it('sends a comment', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/comment' => Http::response([
            'message_id' => 'msg-4',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendComment('session-1', [
        'to' => '12345@newsletter',
        'message_id' => 'msg-0',
        'text' => 'Nice post',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-4');
});

it('sends an invoice', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/invoice' => Http::response([
            'message_id' => 'msg-5',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendInvoice('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'amount' => 10000,
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-5');
});

it('cancels a payment request', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/cancel-payment' => Http::response([
            'message_id' => 'msg-6',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->cancelPaymentRequest('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'message_id' => 'msg-0',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-6');
});

it('declines a payment request', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/decline-payment' => Http::response([
            'message_id' => 'msg-7',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->declinePaymentRequest('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'message_id' => 'msg-0',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-7');
});

it('sends a highly structured message', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/highly-structured' => Http::response([
            'message_id' => 'msg-8',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendHighlyStructured('session-1', [
        'to' => '628123456789@s.whatsapp.net',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-8');
});

it('sends a template button reply', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/template-button-reply' => Http::response([
            'message_id' => 'msg-9',
            'status' => 'sent',
        ]),
    ]);

    $response = $this->client->message->sendTemplateButtonReply('session-1', [
        'to' => '628123456789@s.whatsapp.net',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-9');
});

it('lists chat messages', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/chat/628123456789@s.whatsapp.net*' => Http::response([
            'count' => 1,
            'messages' => [
                ['id' => 'msg-1', 'chat_jid' => '628123456789@s.whatsapp.net'],
            ],
        ]),
    ]);

    $response = $this->client->message->listChatMessages('session-1', '628123456789@s.whatsapp.net', 10, 0);

    expect($response)->toBeInstanceOf(MessageSearchResponse::class)
        ->and($response->count)->toBe(1)
        ->and($response->messages)->toHaveCount(1);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), '/messages/chat/628123456789@s.whatsapp.net')
            && str_contains($request->url(), 'limit=10')
            && str_contains($request->url(), 'offset=0');
    });
});

it('lists session-wide messages with cursor pagination', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages*' => Http::response([
            'count' => 2,
            'messages' => [
                ['id' => 42, 'chat_jid' => 'a@s.whatsapp.net'],
                ['id' => 41, 'chat_jid' => 'b@s.whatsapp.net'],
            ],
            'next_cursor' => 41,
        ]),
    ]);

    $response = $this->client->message->listMessages('session-1', 100, 20);

    expect($response)->toBeInstanceOf(SessionMessagesResponse::class)
        ->and($response->count)->toBe(2)
        ->and($response->messages)->toHaveCount(2)
        ->and($response->nextCursor)->toBe(41);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), '/sessions/session-1/messages')
            && str_contains($request->url(), 'after=100')
            && str_contains($request->url(), 'limit=20');
    });
});
