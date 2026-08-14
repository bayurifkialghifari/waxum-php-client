<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SendTextRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionStatusResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookEventType;

it('round-trips SendTextRequest mentions and mention_all', function () {
    $request = SendTextRequest::fromArray([
        'to' => '120363@g.us',
        'text' => 'hello everyone',
        'mentions' => ['628123456789@s.whatsapp.net', '628987654321'],
        'mention_all' => true,
    ]);

    expect($request->mentions)->toBe(['628123456789@s.whatsapp.net', '628987654321'])
        ->and($request->mentionAll)->toBeTrue();

    $array = $request->toArray();

    expect($array['mentions'])->toBe(['628123456789@s.whatsapp.net', '628987654321'])
        ->and($array['mention_all'])->toBeTrue()
        ->and($array['to'])->toBe('120363@g.us');
});

it('omits mentions fields from SendTextRequest when null', function () {
    $request = SendTextRequest::fromArray([
        'to' => '628123456789@s.whatsapp.net',
        'text' => 'hi',
    ]);

    $array = $request->toArray();

    expect($array)->not->toHaveKey('mentions')
        ->and($array)->not->toHaveKey('mention_all');
});

it('round-trips CreateSessionRequest reuse flag', function () {
    $request = CreateSessionRequest::fromArray([
        'id' => 'my-session',
        'reuse' => true,
    ]);

    expect($request->reuse)->toBeTrue()
        ->and($request->toArray()['reuse'])->toBeTrue();
});

it('omits reuse from CreateSessionRequest when null', function () {
    $request = CreateSessionRequest::fromArray(['name' => 'Test']);

    expect($request->reuse)->toBeNull()
        ->and($request->toArray())->not->toHaveKey('reuse');
});

it('parses socket_alive from SessionStatusResponse', function () {
    $response = SessionStatusResponse::fromArray([
        'status' => 'connected',
        'is_logged_in' => true,
        'socket_alive' => true,
    ]);

    expect($response->socketAlive)->toBeTrue()
        ->and($response->isLoggedIn)->toBeTrue()
        ->and($response->toArray()['socket_alive'])->toBeTrue();
});

it('defaults socket_alive to false in SessionStatusResponse', function () {
    $response = SessionStatusResponse::fromArray([
        'status' => 'disconnected',
        'is_logged_in' => false,
    ]);

    expect($response->socketAlive)->toBeFalse();
});

it('exposes account_locked and not keep_alive_timeout as webhook event types', function () {
    $values = WebhookEventType::values();

    expect($values)->toContain('account_locked')
        ->and($values)->not->toContain('keep_alive_timeout')
        ->and(WebhookEventType::ACCOUNT_LOCKED->value)->toBe('account_locked');
});
