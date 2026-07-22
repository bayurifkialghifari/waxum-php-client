<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SendResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionListResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('lists all sessions', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions' => Http::response([
            'sessions' => [
                ['id' => 'session-1', 'name' => 'Session One', 'is_logged_in' => true],
            ],
            'total' => 1,
        ]),
    ]);

    $response = $this->client->session->list();

    expect($response)->toBeInstanceOf(SessionListResponse::class)
        ->and($response->sessions)->toHaveCount(1);
});

it('sends text message', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/messages/text' => Http::response([
            'message_id' => 'msg-123',
            'status' => 'sent',
            'timestamp' => 1620000000,
        ]),
    ]);

    $response = $this->client->message->sendText('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'text' => 'Hello from Waxum!',
    ]);

    expect($response)->toBeInstanceOf(SendResponse::class)
        ->and($response->messageId)->toBe('msg-123');
});
