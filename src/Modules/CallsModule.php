<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\AcceptCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\PlayCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\PlayCallResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\RejectCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\RingCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\RingCallResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TerminateCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TranscriptResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TtsCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TtsCallResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\VoiceEntry;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Http\Client\Response;

class CallsModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function accept(string $sessionId, AcceptCallRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof AcceptCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/accept", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function play(string $sessionId, PlayCallRequest|array $request, ?string $token = null): PlayCallResponse
    {
        $payload = $request instanceof PlayCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/play", $payload, $token);

        return PlayCallResponse::fromArray((array) $data);
    }

    public function reject(string $sessionId, RejectCallRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof RejectCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/reject", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function ring(string $sessionId, RingCallRequest|array $request, ?string $token = null): RingCallResponse
    {
        $payload = $request instanceof RingCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/ring", $payload, $token);

        return RingCallResponse::fromArray((array) $data);
    }

    public function terminate(string $sessionId, TerminateCallRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof TerminateCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/terminate", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function tts(string $sessionId, TtsCallRequest|array $request, ?string $token = null): TtsCallResponse
    {
        $payload = $request instanceof TtsCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/tts", $payload, $token);

        return TtsCallResponse::fromArray((array) $data);
    }

    /**
     * List the available Edge-TTS voices.
     *
     * @return VoiceEntry[]
     */
    public function voices(?string $token = null): array
    {
        $data = $this->client->get('/api/v1/voices', [], $token);

        return array_map(fn (array $voice) => VoiceEntry::fromArray($voice), (array) $data);
    }

    /**
     * Preview a TTS voice as an audio/mpeg stream.
     */
    public function ttsPreview(string $text, string $voice, ?string $token = null): Response
    {
        return $this->client->requestRaw('GET', '/api/v1/tts/preview', [
            'text' => $text,
            'voice' => $voice,
        ], $token);
    }

    /**
     * Download the WAV recording of a finished call.
     */
    public function recording(string $sessionId, string $callId, ?string $token = null): Response
    {
        return $this->client->requestRaw('GET', "/api/v1/sessions/{$sessionId}/calls/{$callId}/recording.wav", [], $token);
    }

    public function transcript(string $sessionId, string $callId, ?string $token = null): TranscriptResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/calls/{$callId}/transcript", [], $token);

        return TranscriptResponse::fromArray((array) $data);
    }
}
