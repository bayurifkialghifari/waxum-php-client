<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SendResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionStatusResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Status\PairStatus;
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
        ->and($response->sessions)->toHaveCount(1)
        ->and($response->sessions[0])->toBeInstanceOf(SessionInfo::class)
        ->and($response->sessions[0]->id)->toBe('session-1');

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

it('creates a session returning SessionInfo object', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions' => Http::response([
            'session' => [
                'id' => 'device-6a607b96ccfa31784707990',
                'name' => 'TEst',
                'phone_number' => null,
                'push_name' => null,
                'status' => 'disconnected',
                'created_at' => 1784707991,
                'updated_at' => 1784707991,
                'last_connected_at' => null,
                'is_logged_in' => false,
            ],
        ]),
    ]);

    $response = $this->client->session->create(['name' => 'TEst']);

    expect($response)->toBeInstanceOf(CreateSessionResponse::class)
        ->and($response->session)->toBeInstanceOf(SessionInfo::class)
        ->and($response->session->id)->toBe('device-6a607b96ccfa31784707990')
        ->and($response->session->name)->toBe('TEst')
        ->and($response->session->status)->toBe('disconnected')
        ->and($response->session->isLoggedIn)->toBeFalse();
});

it('gets session status returning PairStatus object', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/status' => Http::response([
            'status' => 'waiting_for_qr',
            'is_logged_in' => false,
            'phone_number' => null,
            'push_name' => null,
            'pair' => [
                'last_qr_at' => 1784708453,
                'last_pair_code_at' => null,
                'pair_code_expires_at' => null,
                'last_error' => null,
                'attempts' => 5,
            ],
        ]),
    ]);

    $response = $this->client->session->getStatus('session-1');

    expect($response)->toBeInstanceOf(SessionStatusResponse::class)
        ->and($response->pair)->toBeInstanceOf(PairStatus::class)
        ->and($response->pair->lastQrAt)->toBe(1784708453)
        ->and($response->pair->attempts)->toBe(5)
        ->and($response->status)->toBe('waiting_for_qr')
        ->and($response->isLoggedIn)->toBeFalse();
});
