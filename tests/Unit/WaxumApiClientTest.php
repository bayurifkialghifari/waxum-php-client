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

it('handles array error response messages without TypeError', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions' => Http::response([
            'success' => false,
            'code' => 422,
            'message' => ['to field is required', 'text field is required'],
        ], 422),
    ]);

    try {
        $this->client->get('/api/v1/sessions');
        $this->fail('Expected WaxumApiException to be thrown');
    } catch (WaxumApiException $e) {
        expect($e->getMessage())->toBe('to field is required, text field is required')
            ->and($e->getCode())->toBe(422);
    }
});

it('constructs WaxumApiException safely when passed an array message', function () {
    $exception = new WaxumApiException(['error' => 'array message'], 500);

    expect($exception->getMessage())->toBe('{"error":"array message"}')
        ->and($exception->getCode())->toBe(500);
});
