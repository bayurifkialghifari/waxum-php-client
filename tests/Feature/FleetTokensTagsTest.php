<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\FleetStats;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ReadyzResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ReadyzSession;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ReenableCircuitsResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ServerInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Tag\TagCount;
use Bayurifkialghifari\WaxumApi\DTOs\Tag\TagListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Tag\TagMutateResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Token\MintTokenRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Token\MintTokenResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Token\TokenListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Token\TokenSummary;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('gets server info', function () {
    Http::fake([
        'http://localhost:3451/api/v1/info' => Http::response([
            'version' => '0.5.0',
            'location' => [
                'ip' => '203.0.113.10',
                'country_code' => 'ID',
                'country_name' => 'Indonesia',
                'city' => 'Jakarta',
                'region' => 'Jakarta',
                'latitude' => -6.2,
                'longitude' => 106.8,
                'timezone' => 'Asia/Jakarta',
            ],
        ]),
    ]);

    $response = $this->client->fleet->info();

    expect($response)->toBeInstanceOf(ServerInfo::class)
        ->and($response->version)->toBe('0.5.0')
        ->and($response->location->countryCode)->toBe('ID')
        ->and($response->location->city)->toBe('Jakarta')
        ->and($response->location->latitude)->toBe(-6.2);
});

it('gets fleet stats', function () {
    Http::fake([
        'http://localhost:3451/api/v1/stats' => Http::response([
            'session_total' => 5,
            'session_connected' => 3,
            'session_connecting' => 1,
            'session_disconnected' => 1,
            'session_logged_out' => 0,
            'webhook_total' => 4,
            'webhook_circuits_open' => 1,
            'event_rate_per_min' => 120,
            'uptime_seconds' => 3600,
            'version' => '0.5.0',
            'storage_path' => '/var/lib/waxum',
        ]),
    ]);

    $response = $this->client->fleet->stats();

    expect($response)->toBeInstanceOf(FleetStats::class)
        ->and($response->sessionTotal)->toBe(5)
        ->and($response->sessionConnected)->toBe(3)
        ->and($response->webhookCircuitsOpen)->toBe(1)
        ->and($response->eventRatePerMin)->toBe(120)
        ->and($response->uptimeSeconds)->toBe(3600)
        ->and($response->version)->toBe('0.5.0')
        ->and($response->storagePath)->toBe('/var/lib/waxum');
});

it('re-enables all webhook circuits', function () {
    Http::fake([
        'http://localhost:3451/api/v1/webhooks/reenable-all' => Http::response([
            'reenabled' => ['session-1'],
            'total' => 1,
        ]),
    ]);

    $response = $this->client->fleet->reenableAllWebhooks();

    expect($response)->toBeInstanceOf(ReenableCircuitsResponse::class)
        ->and($response->reenabled)->toBe(['session-1'])
        ->and($response->total)->toBe(1);
});

it('checks health and liveness probes', function () {
    Http::fake([
        'http://localhost:3451/health' => Http::response('OK', 200, ['Content-Type' => 'text/plain']),
        'http://localhost:3451/livez' => Http::response('OK', 200, ['Content-Type' => 'text/plain']),
    ]);

    expect($this->client->fleet->health())->toBe('OK')
        ->and($this->client->fleet->live())->toBe('OK');
});

it('checks readiness probe', function () {
    Http::fake([
        'http://localhost:3451/readyz' => Http::response([
            'db' => 'ok',
            'sessions_known' => 2,
            'sessions_live' => 1,
            'sessions' => [
                ['id' => 'session-1', 'status' => 'connected', 'socket_alive' => true],
                ['id' => 'session-2', 'status' => 'disconnected', 'socket_alive' => false],
            ],
        ]),
    ]);

    $response = $this->client->fleet->ready();

    expect($response)->toBeInstanceOf(ReadyzResponse::class)
        ->and($response->db)->toBe('ok')
        ->and($response->sessionsKnown)->toBe(2)
        ->and($response->sessionsLive)->toBe(1)
        ->and($response->sessions[0])->toBeInstanceOf(ReadyzSession::class)
        ->and($response->sessions[0]->id)->toBe('session-1')
        ->and($response->sessions[0]->socketAlive)->toBeTrue()
        ->and($response->sessions[1]->socketAlive)->toBeFalse();
});

it('mints a token', function () {
    Http::fake([
        'http://localhost:3451/api/v1/tokens' => Http::response([
            'id' => 'token-id-1',
            'token' => 'raw-bearer-value',
            'name' => 'customer-mobile-app',
            'session_ids' => ['session-1'],
            'expires_at' => 1785000000,
        ]),
    ]);

    $response = $this->client->tokens->mint(new MintTokenRequest(
        name: 'customer-mobile-app',
        sessionIds: ['session-1'],
        expiresInHours: 720,
    ));

    expect($response)->toBeInstanceOf(MintTokenResponse::class)
        ->and($response->id)->toBe('token-id-1')
        ->and($response->token)->toBe('raw-bearer-value')
        ->and($response->sessionIds)->toBe(['session-1'])
        ->and($response->expiresAt)->toBe(1785000000);

    Http::assertSent(function ($request) {
        return $request->method() === 'POST'
            && $request['name'] === 'customer-mobile-app'
            && $request['session_ids'] === ['session-1']
            && $request['expires_in_hours'] === 720;
    });
});

it('mints a token from an array payload', function () {
    Http::fake([
        'http://localhost:3451/api/v1/tokens' => Http::response([
            'id' => 'token-id-2',
            'token' => 'raw-bearer-value-2',
            'name' => null,
            'session_ids' => ['session-2'],
            'expires_at' => 1785000000,
        ]),
    ]);

    $response = $this->client->tokens->mint(['session_ids' => ['session-2']]);

    expect($response)->toBeInstanceOf(MintTokenResponse::class)
        ->and($response->id)->toBe('token-id-2')
        ->and($response->name)->toBeNull();
});

it('lists tokens', function () {
    Http::fake([
        'http://localhost:3451/api/v1/tokens' => Http::response([
            'tokens' => [
                [
                    'id' => 'token-id-1',
                    'name' => 'customer-mobile-app',
                    'session_ids' => ['session-1'],
                    'created_at' => '2026-08-01T00:00:00Z',
                    'expires_at' => '2026-08-31T00:00:00Z',
                    'revoked' => false,
                ],
            ],
            'count' => 1,
        ]),
    ]);

    $response = $this->client->tokens->list();

    expect($response)->toBeInstanceOf(TokenListResponse::class)
        ->and($response->count)->toBe(1)
        ->and($response->tokens[0])->toBeInstanceOf(TokenSummary::class)
        ->and($response->tokens[0]->id)->toBe('token-id-1')
        ->and($response->tokens[0]->revoked)->toBeFalse();
});

it('revokes a token', function () {
    Http::fake([
        'http://localhost:3451/api/v1/tokens/token-id-1/revoke' => Http::response([
            'success' => true,
            'message' => 'Token revoked',
        ]),
    ]);

    $response = $this->client->tokens->revoke('token-id-1');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

it('lists all tags with counts', function () {
    Http::fake([
        'http://localhost:3451/api/v1/tags' => Http::response([
            ['tag' => 'cs', 'session_count' => 3],
            ['tag' => 'region:jkt', 'session_count' => 1],
        ]),
    ]);

    $response = $this->client->tags->list();

    expect($response)->toHaveCount(2)
        ->and($response[0])->toBeInstanceOf(TagCount::class)
        ->and($response[0]->tag)->toBe('cs')
        ->and($response[0]->sessionCount)->toBe(3);
});

it('lists tags for a session', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/tags' => Http::response([
            'session_id' => 'session-1',
            'tags' => ['cs', 'region:jkt'],
        ]),
    ]);

    $response = $this->client->tags->forSession('session-1');

    expect($response)->toBeInstanceOf(TagListResponse::class)
        ->and($response->sessionId)->toBe('session-1')
        ->and($response->tags)->toBe(['cs', 'region:jkt']);
});

it('replaces the tag set of a session', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/tags' => Http::response([
            'session_id' => 'session-1',
            'tags' => ['blast-campaign-2'],
        ]),
    ]);

    $response = $this->client->tags->setTags('session-1', ['blast-campaign-2']);

    expect($response)->toBeInstanceOf(TagListResponse::class)
        ->and($response->tags)->toBe(['blast-campaign-2']);

    Http::assertSent(function ($request) {
        return $request->method() === 'PUT'
            && $request['tags'] === ['blast-campaign-2'];
    });
});

it('adds a tag to a session', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/tags' => Http::response([
            'session_id' => 'session-1',
            'tag' => 'cs',
            'changed' => true,
            'tags' => ['cs'],
        ]),
    ]);

    $response = $this->client->tags->add('session-1', 'cs');

    expect($response)->toBeInstanceOf(TagMutateResponse::class)
        ->and($response->tag)->toBe('cs')
        ->and($response->changed)->toBeTrue()
        ->and($response->tags)->toBe(['cs']);

    Http::assertSent(function ($request) {
        return $request->method() === 'POST'
            && $request['tag'] === 'cs';
    });
});

it('removes a tag from a session', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/tags/cs' => Http::response([
            'session_id' => 'session-1',
            'tag' => 'cs',
            'changed' => true,
            'tags' => [],
        ]),
    ]);

    $response = $this->client->tags->remove('session-1', 'cs');

    expect($response)->toBeInstanceOf(TagMutateResponse::class)
        ->and($response->changed)->toBeTrue()
        ->and($response->tags)->toBe([]);

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});
