<?php

use Bayurifkialghifari\WaxumApi\DTOs\Bots\BotListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Bots\CappingResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('lists bots', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/bots' => Http::response([
            'bots' => '[Bot { id: "bot-1" }]',
        ]),
    ]);

    $response = $this->client->bots->bots('session-1');

    expect($response)->toBeInstanceOf(BotListResponse::class)
        ->and($response->bots)->toBe('[Bot { id: "bot-1" }]');
});

it('gets capping status', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/capping' => Http::response([
            'capping' => null,
            'note' => 'capping query requires mex; use /mex/query with NewChatCapping doc',
        ]),
    ]);

    $response = $this->client->bots->capping('session-1');

    expect($response)->toBeInstanceOf(CappingResponse::class)
        ->and($response->capping)->toBeNull()
        ->and($response->note)->toContain('capping query requires mex');
});
