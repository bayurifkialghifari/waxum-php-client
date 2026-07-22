<?php

use Bayurifkialghifari\WaxumApi\Exceptions\WaxumApiException;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('resolves WaxumApiClient from the container', function () {
    $client = app(WaxumApiClient::class);

    expect($client)->toBeInstanceOf(WaxumApiClient::class);
});

it('resolves WaxumApiClient via facade accessor', function () {
    $client = app('waxum');

    expect($client)->toBeInstanceOf(WaxumApiClient::class);
});

it('throws WaxumApiException when token is missing', function () {
    $client = new WaxumApiClient('http://localhost:3451'); // no token

    expect(fn () => $client->get('/api/v1/sessions'))->toThrow(WaxumApiException::class);
});

it('throws WaxumApiException on API failure response', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions' => Http::response([
            'success' => false,
            'code' => 401,
            'error' => 'Unauthorized',
        ], 401),
    ]);

    expect(fn () => $this->client->get('/api/v1/sessions'))->toThrow(WaxumApiException::class);
});

it('sends Authorization header with Bearer token', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions' => Http::response([
            'success' => true,
            'code' => 200,
            'data' => [],
        ]),
    ]);

    $this->client->get('/api/v1/sessions');

    Http::assertSent(function ($request) {
        return $request->hasHeader('Authorization', 'Bearer test-token');
    });
});
