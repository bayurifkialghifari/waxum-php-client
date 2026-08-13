<?php

use Bayurifkialghifari\WaxumApi\DTOs\Session\AppStateResyncMode;
use Bayurifkialghifari\WaxumApi\DTOs\Session\AppStateResyncResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\PauseStateResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionStatusResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookEventType;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('pauses a session', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/pause' => Http::response([
            'paused' => true,
        ]),
    ]);

    $response = $this->client->session->pause('session-1');

    expect($response)->toBeInstanceOf(PauseStateResponse::class)
        ->and($response->paused)->toBeTrue()
        ->and($response->toArray())->toBe(['paused' => true]);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request->url() === 'http://localhost:3451/api/v1/sessions/session-1/pause');
});

it('resumes a session', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/resume' => Http::response([
            'paused' => false,
        ]),
    ]);

    $response = $this->client->session->resume('session-1');

    expect($response)->toBeInstanceOf(PauseStateResponse::class)
        ->and($response->paused)->toBeFalse();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request->url() === 'http://localhost:3451/api/v1/sessions/session-1/resume');
});

it('resyncs app-state collections with default (omitted) mode', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/appstate/resync' => Http::response([
            'synced' => ['critical_block', 'regular_low'],
            'fatal' => [],
            'retryable' => [],
            'skipped' => [],
            'all_synced' => true,
        ]),
    ]);

    $response = $this->client->session->resyncAppState('session-1', ['critical_block', 'regular_low']);

    expect($response)->toBeInstanceOf(AppStateResyncResponse::class)
        ->and($response->synced)->toBe(['critical_block', 'regular_low'])
        ->and($response->fatal)->toBe([])
        ->and($response->retryable)->toBe([])
        ->and($response->skipped)->toBe([])
        ->and($response->allSynced)->toBeTrue()
        ->and($response->toArray())->toBe([
            'all_synced' => true,
            'fatal' => [],
            'retryable' => [],
            'skipped' => [],
            'synced' => ['critical_block', 'regular_low'],
        ]);

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'POST'
            && $request->url() === 'http://localhost:3451/api/v1/sessions/session-1/appstate/resync'
            && $body === ['collections' => ['critical_block', 'regular_low']];
    });
});

it('resyncs app-state collections with explicit snapshot mode', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/appstate/resync' => Http::response([
            'synced' => ['regular'],
            'fatal' => [],
            'retryable' => ['regular_high'],
            'skipped' => [],
            'all_synced' => false,
        ]),
    ]);

    $response = $this->client->session->resyncAppState('session-1', ['regular', 'regular_high'], AppStateResyncMode::SNAPSHOT);

    expect($response)->toBeInstanceOf(AppStateResyncResponse::class)
        ->and($response->synced)->toBe(['regular'])
        ->and($response->retryable)->toBe(['regular_high'])
        ->and($response->allSynced)->toBeFalse();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'POST'
            && $body === [
                'collections' => ['regular', 'regular_high'],
                'mode' => 'snapshot',
            ];
    });
});

it('accepts the resync mode as a plain string', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/appstate/resync' => Http::response([
            'synced' => [],
            'fatal' => [],
            'retryable' => ['regular_low'],
            'skipped' => ['regular'],
            'all_synced' => false,
        ]),
    ]);

    $response = $this->client->session->resyncAppState('session-1', ['regular_low', 'regular'], 'incremental');

    expect($response->skipped)->toBe(['regular']);

    Http::assertSent(fn ($request) => json_decode($request->body(), true) === [
        'collections' => ['regular_low', 'regular'],
        'mode' => 'incremental',
    ]);
});

it('exposes the resync mode enum values', function () {
    expect(AppStateResyncMode::values())->toBe(['incremental', 'snapshot']);
});

it('maps the paused flag on session status', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/status' => Http::response([
            'status' => 'connected',
            'is_logged_in' => true,
            'socket_alive' => true,
            'paused' => true,
        ]),
    ]);

    $response = $this->client->session->getStatus('session-1');

    expect($response)->toBeInstanceOf(SessionStatusResponse::class)
        ->and($response->paused)->toBeTrue()
        ->and($response->toArray()['paused'])->toBeTrue();
});

it('defaults paused to false when the status payload omits it', function () {
    $response = SessionStatusResponse::fromArray([
        'status' => 'disconnected',
        'is_logged_in' => false,
    ]);

    expect($response->paused)->toBeFalse();
});

it('exposes the new webhook event types', function () {
    expect(WebhookEventType::CALL_LOG_SYNC->value)->toBe('call_log_sync')
        ->and(WebhookEventType::STREAM_ERROR->value)->toBe('stream_error')
        ->and(WebhookEventType::ENC_DECRYPT_FAILED->value)->toBe('enc_decrypt_failed');

    expect(WebhookEventType::values())->toContain('call_log_sync', 'stream_error', 'enc_decrypt_failed');
});
