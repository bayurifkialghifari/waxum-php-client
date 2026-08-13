<?php

namespace Bayurifkialghifari\WaxumApi;

use Illuminate\Http\Request;

class WebhookSignature
{
    public const SIGNATURE_HEADER = 'X-Webhook-Signature';

    public const SIGNATURE_VERSION_HEADER = 'X-Webhook-Signature-Version';

    public const SIGNATURE_VERSION = 'v2';

    public const TIMESTAMP_HEADER = 'X-Webhook-Timestamp';

    /**
     * Verify a waxum v2 webhook signature.
     *
     * The server signs `"{timestamp}.{raw_body}"` with HMAC-SHA256 and sends
     * it as `X-Webhook-Signature: sha256=<hex>` alongside
     * `X-Webhook-Timestamp: <unix>` and `X-Webhook-Signature-Version: v2`.
     * Timestamps outside the tolerance window are rejected (replay protection).
     */
    public static function verify(
        string $rawBody,
        string $timestamp,
        string $signatureHeader,
        string $secret,
        int $toleranceSeconds = 300,
    ): bool {
        if (! ctype_digit($timestamp)) {
            return false;
        }

        if (abs(time() - (int) $timestamp) > $toleranceSeconds) {
            return false;
        }

        if (! str_starts_with($signatureHeader, 'sha256=')) {
            return false;
        }

        $signature = substr($signatureHeader, 7);

        if (! ctype_xdigit($signature)) {
            return false;
        }

        $expected = hash_hmac('sha256', "{$timestamp}.{$rawBody}", $secret);

        return hash_equals($expected, strtolower($signature));
    }

    /**
     * Verify a Laravel incoming request carrying the waxum webhook headers.
     * Returns false when any of the required headers is missing.
     */
    public static function fromRequest(Request $request, string $secret, int $toleranceSeconds = 300): bool
    {
        $timestamp = $request->header(self::TIMESTAMP_HEADER);
        $signature = $request->header(self::SIGNATURE_HEADER);

        if (! is_string($timestamp) || ! is_string($signature)) {
            return false;
        }

        return self::verify($request->getContent(), $timestamp, $signature, $secret, $toleranceSeconds);
    }
}
