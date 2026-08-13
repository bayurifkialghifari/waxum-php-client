<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\TranscriptResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\VoiceEntry;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('lists tts voices', function () {
    Http::fake([
        'http://localhost:3451/api/v1/voices' => Http::response([
            [
                'name' => 'Microsoft Ardi Online (Natural) - Indonesian (Indonesia)',
                'short_name' => 'id-ID-ArdiNeural',
                'locale' => 'id-ID',
                'gender' => 'Male',
                'friendly_name' => 'Microsoft Ardi Online (Natural) - Indonesian (Indonesia)',
            ],
        ]),
    ]);

    $voices = $this->client->calls->voices();

    expect($voices)->toHaveCount(1)
        ->and($voices[0])->toBeInstanceOf(VoiceEntry::class)
        ->and($voices[0]->shortName)->toBe('id-ID-ArdiNeural')
        ->and($voices[0]->locale)->toBe('id-ID');
});

it('previews a tts voice as audio stream', function () {
    Http::fake([
        'http://localhost:3451/api/v1/tts/preview*' => Http::response('fake-mp3-bytes', 200, [
            'Content-Type' => 'audio/mpeg',
        ]),
    ]);

    $response = $this->client->calls->ttsPreview('Halo dunia', 'id-ID-ArdiNeural');

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->body())->toBe('fake-mp3-bytes');

    Http::assertSent(function ($request) {
        return str_contains($request->url(), '/api/v1/tts/preview')
            && str_contains($request->url(), 'voice=id-ID-ArdiNeural');
    });
});

it('downloads a call recording', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/calls/call-1/recording.wav' => Http::response('RIFF-fake-wav', 200, [
            'Content-Type' => 'audio/wav',
        ]),
    ]);

    $response = $this->client->calls->recording('session-1', 'call-1');

    expect($response)->toBeInstanceOf(Response::class)
        ->and($response->body())->toBe('RIFF-fake-wav');
});

it('transcribes a call recording', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/calls/call-1/transcript' => Http::response([
            'text' => 'halo, ini transkrip panggilan',
        ]),
    ]);

    $response = $this->client->calls->transcript('session-1', 'call-1');

    expect($response)->toBeInstanceOf(TranscriptResponse::class)
        ->and($response->text)->toBe('halo, ini transkrip panggilan');
});
