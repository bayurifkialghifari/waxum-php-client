<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\ChatState\SendChatStateRequest;
use Bayurifkialghifari\WaxumApi\DTOs\ChatState\SendTypingRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class ChatStateModule
{
    public function __construct(protected WaxumApiClient $client) {}

    /**
     * Send chat state (composing, recording, paused).
     */
    public function sendChatState(string $sessionId, SendChatStateRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof SendChatStateRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/chatstate/send", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    /**
     * Alias for sendChatState (sendChatPresence).
     */
    public function sendChatPresence(string $sessionId, SendChatStateRequest|array $request, ?string $token = null): SuccessResponse
    {
        return $this->sendChatState($sessionId, $request, $token);
    }

    /**
     * Send typing indicator to a recipient.
     */
    public function sendTyping(string $sessionId, SendTypingRequest|array|string $request, ?int $duration = null, ?string $token = null): SuccessResponse
    {
        if ($request instanceof SendTypingRequest) {
            $payload = $request->toArray();
        } elseif (is_string($request)) {
            $payload = array_filter([
                'to' => $request,
                'duration' => $duration,
            ], fn ($val) => $val !== null);
        } else {
            $payload = $request;
            if ($duration !== null && ! isset($payload['duration'])) {
                $payload['duration'] = $duration;
            }
        }

        $data = $this->client->post("/api/v1/sessions/{$sessionId}/chatstate/typing", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
