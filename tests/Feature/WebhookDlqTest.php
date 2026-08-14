<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookDlqEntry;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookDlqListResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('lists webhook DLQ entries', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/webhooks/dlq' => Http::response([
            'entries' => [
                [
                    'id' => 'entry-1',
                    'session_id' => 'session-1',
                    'webhook_url' => 'https://example.com/hook',
                    'event' => 'message',
                    'payload' => '{"event":"message"}',
                    'last_error' => 'connection refused',
                    'attempts' => 5,
                    'failed_at' => 1784709000,
                ],
            ],
            'count' => 1,
        ]),
    ]);

    $response = $this->client->webhook->listDlq('session-1');

    expect($response)->toBeInstanceOf(WebhookDlqListResponse::class)
        ->and($response->count)->toBe(1)
        ->and($response->entries)->toHaveCount(1)
        ->and($response->entries[0])->toBeInstanceOf(WebhookDlqEntry::class)
        ->and($response->entries[0]->id)->toBe('entry-1')
        ->and($response->entries[0]->sessionId)->toBe('session-1')
        ->and($response->entries[0]->webhookUrl)->toBe('https://example.com/hook')
        ->and($response->entries[0]->event)->toBe('message')
        ->and($response->entries[0]->payload)->toBe('{"event":"message"}')
        ->and($response->entries[0]->lastError)->toBe('connection refused')
        ->and($response->entries[0]->attempts)->toBe(5)
        ->and($response->entries[0]->failedAt)->toBe(1784709000);
});

it('replays a webhook DLQ entry', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/webhooks/dlq/entry-1/replay' => Http::response([
            'success' => true,
            'message' => 'Webhook DLQ entry replay scheduled',
        ]),
    ]);

    $response = $this->client->webhook->replayDlq('session-1', 'entry-1');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue()
        ->and($response->message)->toBe('Webhook DLQ entry replay scheduled');
});
