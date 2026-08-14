<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\DisconnectAllResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\PurgeResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\ReconnectAllResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SearchHit;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SearchResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionExport;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('purges sessions with query filter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/purge*' => Http::response([
            'filter' => 'inactive',
            'days' => 30,
            'dry_run' => true,
            'purged' => ['old-session'],
            'kept' => 2,
            'total_before' => 3,
        ]),
    ]);

    $response = $this->client->session->purge(['filter' => 'inactive', 'days' => 30, 'dry_run' => true]);

    expect($response)->toBeInstanceOf(PurgeResponse::class)
        ->and($response->filter)->toBe('inactive')
        ->and($response->days)->toBe(30)
        ->and($response->dryRun)->toBeTrue()
        ->and($response->purged)->toBe(['old-session'])
        ->and($response->kept)->toBe(2)
        ->and($response->totalBefore)->toBe(3);

    Http::assertSent(function ($request) {
        return $request->method() === 'POST'
            && str_starts_with($request->url(), 'http://localhost:3451/api/v1/sessions/purge?')
            && str_contains($request->url(), 'filter=inactive')
            && str_contains($request->url(), 'days=30')
            && str_contains($request->url(), 'dry_run=true');
    });
});

it('disconnects all sessions', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/disconnect-all' => Http::response([
            'disconnected' => ['session-1'],
            'skipped' => ['session-2'],
            'total' => 2,
        ]),
    ]);

    $response = $this->client->session->disconnectAll();

    expect($response)->toBeInstanceOf(DisconnectAllResponse::class)
        ->and($response->disconnected)->toBe(['session-1'])
        ->and($response->skipped)->toBe(['session-2'])
        ->and($response->total)->toBe(2);
});

it('reconnects all sessions', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/reconnect-all' => Http::response([
            'scheduled' => ['session-1', 'session-2'],
            'skipped' => [],
            'total' => 2,
        ]),
    ]);

    $response = $this->client->session->reconnectAll();

    expect($response)->toBeInstanceOf(ReconnectAllResponse::class)
        ->and($response->scheduled)->toBe(['session-1', 'session-2'])
        ->and($response->skipped)->toBe([])
        ->and($response->total)->toBe(2);
});

it('searches sessions by query', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/search*' => Http::response([
            'q' => 'acme',
            'total' => 1,
            'hits' => [
                [
                    'id' => 'session-1',
                    'name' => 'acme-main',
                    'phone_number' => '628123456789',
                    'push_name' => 'Acme',
                    'status' => 'connected',
                    'is_logged_in' => true,
                    'match_on' => ['name'],
                ],
            ],
        ]),
    ]);

    $response = $this->client->session->search('acme');

    expect($response)->toBeInstanceOf(SearchResponse::class)
        ->and($response->q)->toBe('acme')
        ->and($response->total)->toBe(1)
        ->and($response->hits[0])->toBeInstanceOf(SearchHit::class)
        ->and($response->hits[0]->id)->toBe('session-1')
        ->and($response->hits[0]->phoneNumber)->toBe('628123456789')
        ->and($response->hits[0]->isLoggedIn)->toBeTrue()
        ->and($response->hits[0]->matchOn)->toBe(['name']);

    Http::assertSent(function ($request) {
        return $request->method() === 'GET'
            && str_contains($request->url(), 'q=acme');
    });
});

it('exports a session as a zip download', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/export' => Http::response(
            'PK fake-zip-bytes',
            200,
            ['Content-Type' => 'application/zip'],
        ),
    ]);

    $export = $this->client->session->export('session-1');

    expect($export)->toBeInstanceOf(SessionExport::class)
        ->and($export->body())->toBe('PK fake-zip-bytes')
        ->and($export->size())->toBe(strlen('PK fake-zip-bytes'));

    $target = tempnam(sys_get_temp_dir(), 'waxum-export-');

    try {
        expect($export->saveAs($target))->toBe($target)
            ->and(file_get_contents($target))->toBe('PK fake-zip-bytes');
    } finally {
        unlink($target);
    }
});

it('imports a session zip as multipart form data', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/import' => Http::response([
            'success' => true,
            'message' => 'Session storage imported — call /connect to bring it online',
        ]),
    ]);

    $file = tempnam(sys_get_temp_dir(), 'waxum-test-');
    file_put_contents($file, 'fake-zip-bytes');

    try {
        $response = $this->client->session->import('session-1', $file);
    } finally {
        unlink($file);
    }

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        return str_contains($request->header('Content-Type')[0] ?? '', 'multipart/form-data')
            && str_contains($request->body(), 'name="file"')
            && str_contains($request->body(), 'fake-zip-bytes');
    });
});
