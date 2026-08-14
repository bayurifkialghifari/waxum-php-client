<?php

use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessCatalogResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessCollectionsResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessOrderResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessProfileUpdateRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('gets a business catalog', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/business/catalog*' => Http::response([
            'products' => '[Product { id: "1" }]',
            'after_cursor' => 'cursor-1',
            'before_cursor' => null,
        ]),
    ]);

    $response = $this->client->business->catalog('session-1', '559999999999@s.whatsapp.net', 10, 100, 100);

    expect($response)->toBeInstanceOf(BusinessCatalogResponse::class)
        ->and($response->products)->toBe('[Product { id: "1" }]')
        ->and($response->afterCursor)->toBe('cursor-1');

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'jid=559999999999%40s.whatsapp.net')
            && str_contains($request->url(), 'limit=10');
    });
});

it('gets business collections', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/business/collections*' => Http::response([
            'collections' => '[Collection { id: "c1" }]',
            'after_cursor' => 'cursor-2',
        ]),
    ]);

    $response = $this->client->business->collections('session-1', '559999999999@s.whatsapp.net', 5, 3);

    expect($response)->toBeInstanceOf(BusinessCollectionsResponse::class)
        ->and($response->collections)->toBe('[Collection { id: "c1" }]')
        ->and($response->afterCursor)->toBe('cursor-2');

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'limit=5')
            && str_contains($request->url(), 'item_limit=3');
    });
});

it('gets a business order', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/business/order*' => Http::response([
            'order' => 'Order { id: "ORDER_ID_123" }',
        ]),
    ]);

    $response = $this->client->business->order('session-1', '559999999999@s.whatsapp.net', 'ORDER_ID_123', 'order-token');

    expect($response)->toBeInstanceOf(BusinessOrderResponse::class)
        ->and($response->order)->toBe('Order { id: "ORDER_ID_123" }');

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'order_id=ORDER_ID_123')
            && str_contains($request->url(), 'token=order-token');
    });
});

it('updates the business profile', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/business/profile' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->business->updateProfile('session-1', new BusinessProfileUpdateRequest(
        description: 'We sell things',
        email: 'shop@example.com',
        websites: ['https://shop.example.com'],
    ));

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'PATCH'
            && $body['description'] === 'We sell things'
            && $body['websites'] === ['https://shop.example.com'];
    });
});

it('deletes a business cover photo', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/business/cover-photo/photo-1' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->business->deleteCoverPhoto('session-1', 'photo-1');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();
});
