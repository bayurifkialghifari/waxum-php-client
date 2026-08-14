<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterAdminInfoResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterFollowersResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterMetadataResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterMuteResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('lists subscribed newsletters', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/subscribed' => Http::response([
            'newsletters' => '[Newsletter { id: "12345@newsletter" }]',
        ]),
    ]);

    $response = $this->client->newsletter->subscribed('session-1');

    expect($response)->toBeInstanceOf(NewsletterListResponse::class)
        ->and($response->newsletters)->toBe('[Newsletter { id: "12345@newsletter" }]');
});

it('creates a newsletter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters' => Http::response([
            'metadata' => 'Metadata { id: "12345@newsletter" }',
        ]),
    ]);

    $response = $this->client->newsletter->create('session-1', 'My Channel', 'A description');

    expect($response)->toBeInstanceOf(NewsletterMetadataResponse::class)
        ->and($response->metadata)->toBe('Metadata { id: "12345@newsletter" }');

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'POST'
            && $body['name'] === 'My Channel'
            && $body['description'] === 'A description';
    });
});

it('gets newsletter metadata', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/metadata' => Http::response([
            'metadata' => 'Metadata { id: "12345@newsletter" }',
        ]),
    ]);

    $response = $this->client->newsletter->metadata('session-1', '12345@newsletter');

    expect($response)->toBeInstanceOf(NewsletterMetadataResponse::class)
        ->and($response->metadata)->toBe('Metadata { id: "12345@newsletter" }');
});

it('joins a newsletter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/join' => Http::response([
            'metadata' => 'Metadata { id: "12345@newsletter" }',
        ]),
    ]);

    $response = $this->client->newsletter->join('session-1', '12345@newsletter');

    expect($response)->toBeInstanceOf(NewsletterMetadataResponse::class);
});

it('leaves a newsletter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/leave' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->newsletter->leave('session-1', '12345@newsletter');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();
});

it('deletes a newsletter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->newsletter->delete('session-1', '12345@newsletter');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});

it('changes the newsletter owner', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/change-owner' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->newsletter->changeOwner('session-1', '12345@newsletter', '628123456789@s.whatsapp.net');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $body['user'] === '628123456789@s.whatsapp.net';
    });
});

it('demotes a newsletter admin', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/demote' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->newsletter->demote('session-1', '12345@newsletter', '628123456789@s.whatsapp.net');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $body['user'] === '628123456789@s.whatsapp.net';
    });
});

it('gets newsletter admin info', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/admin-info' => Http::response([
            'admin_info' => 'AdminInfo { admins: 2 }',
        ]),
    ]);

    $response = $this->client->newsletter->adminInfo('session-1', '12345@newsletter');

    expect($response)->toBeInstanceOf(NewsletterAdminInfoResponse::class)
        ->and($response->adminInfo)->toBe('AdminInfo { admins: 2 }');
});

it('gets newsletter followers', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/followers*' => Http::response([
            'followers' => '[Follower { jid: "628123456789@s.whatsapp.net" }]',
        ]),
    ]);

    $response = $this->client->newsletter->followers('session-1', '12345@newsletter', 25);

    expect($response)->toBeInstanceOf(NewsletterFollowersResponse::class)
        ->and($response->followers)->toBe('[Follower { jid: "628123456789@s.whatsapp.net" }]');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'limit=25'));
});

it('mutes a newsletter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/newsletters/12345@newsletter/mute' => Http::response([
            'success' => true,
            'muted' => true,
        ]),
    ]);

    $response = $this->client->newsletter->mute('session-1', '12345@newsletter', true);

    expect($response)->toBeInstanceOf(NewsletterMuteResponse::class)
        ->and($response->success)->toBeTrue()
        ->and($response->muted)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $body['muted'] === true;
    });
});
