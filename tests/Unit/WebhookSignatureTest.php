<?php

use Bayurifkialghifari\WaxumApi\WebhookSignature;

it('verifies a valid v2 webhook signature', function () {
    $secret = 'webhook-secret';
    $body = '{"event":"message"}';
    $timestamp = (string) time();
    $signature = 'sha256='.hash_hmac('sha256', "{$timestamp}.{$body}", $secret);

    expect(WebhookSignature::verify($body, $timestamp, $signature, $secret))->toBeTrue();
});

it('rejects a signature computed with the wrong secret', function () {
    $body = '{"event":"message"}';
    $timestamp = (string) time();
    $signature = 'sha256='.hash_hmac('sha256', "{$timestamp}.{$body}", 'another-secret');

    expect(WebhookSignature::verify($body, $timestamp, $signature, 'webhook-secret'))->toBeFalse();
});

it('rejects a stale timestamp outside the tolerance window', function () {
    $secret = 'webhook-secret';
    $body = '{"event":"message"}';
    $timestamp = (string) (time() - 1000);
    $signature = 'sha256='.hash_hmac('sha256', "{$timestamp}.{$body}", $secret);

    expect(WebhookSignature::verify($body, $timestamp, $signature, $secret))->toBeFalse();
});

it('rejects a malformed signature header', function (string $header) {
    $secret = 'webhook-secret';
    $body = '{"event":"message"}';
    $timestamp = (string) time();

    expect(WebhookSignature::verify($body, $timestamp, $header, $secret))->toBeFalse();
})->with([
    'missing sha256 prefix' => ['deadbeef'],
    'wrong algorithm prefix' => ['sha1='.hash('sha1', 'x')],
    'non-hex signature' => ['sha256=not-hex-at-all!'],
    'empty signature' => ['sha256='],
]);

it('rejects a non-numeric timestamp', function () {
    $secret = 'webhook-secret';
    $body = '{"event":"message"}';
    $signature = 'sha256='.hash_hmac('sha256', "abc.{$body}", $secret);

    expect(WebhookSignature::verify($body, 'abc', $signature, $secret))->toBeFalse();
});

it('rejects a tampered body', function () {
    $secret = 'webhook-secret';
    $timestamp = (string) time();
    $signature = 'sha256='.hash_hmac('sha256', "{$timestamp}.{original}", $secret);

    expect(WebhookSignature::verify('tampered', $timestamp, $signature, $secret))->toBeFalse();
});
