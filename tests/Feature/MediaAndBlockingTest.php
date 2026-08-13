<?php

use Bayurifkialghifari\WaxumApi\DTOs\Media\UploadMediaResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Status\BlockStatusResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('uploads media as multipart form data', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/media/upload' => Http::response([
            'url' => 'https://mmg.whatsapp.net/enc/file',
            'direct_path' => '/v/t62/file.enc',
            'media_key' => 'media-key',
            'mimetype' => 'image/jpeg',
            'file_sha256' => 'sha256',
            'file_enc_sha256' => 'enc-sha256',
            'file_length' => 12345,
            'media_type' => 'image',
        ]),
    ]);

    $file = tempnam(sys_get_temp_dir(), 'waxum-test-');
    file_put_contents($file, 'fake-image-bytes');

    try {
        $response = $this->client->media->upload('session-1', $file, 'image');
    } finally {
        unlink($file);
    }

    expect($response)->toBeInstanceOf(UploadMediaResponse::class)
        ->and($response->url)->toBe('https://mmg.whatsapp.net/enc/file')
        ->and($response->fileLength)->toBe(12345);

    Http::assertSent(function ($request) {
        return str_contains($request->header('Content-Type')[0] ?? '', 'multipart/form-data')
            && str_contains($request->body(), 'name="file"')
            && str_contains($request->body(), 'fake-image-bytes')
            && str_contains($request->body(), 'name="media_type"')
            && ! str_contains($request->header('Content-Type')[0] ?? '', 'application/json');
    });
});

it('checks blocked status using the Status DTO', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/blocking/check/628123456789@s.whatsapp.net' => Http::response([
            'jid' => '628123456789@s.whatsapp.net',
            'is_blocked' => true,
        ]),
    ]);

    $response = $this->client->blocking->isBlocked('session-1', '628123456789@s.whatsapp.net');

    expect($response)->toBeInstanceOf(BlockStatusResponse::class)
        ->and($response->isBlocked)->toBeTrue()
        ->and($response->jid)->toBe('628123456789@s.whatsapp.net');
});
