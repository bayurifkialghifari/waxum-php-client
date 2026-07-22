<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class ChatStateModule
{
    public function __construct(protected WaxumApiClient $client) {}

    /**
     * Send chat state (composing, recording, paused).
     */
    public function sendChatState(string $sessionId, array $data, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/chatstate/send", $data, $token);
    }

    /**
     * Send typing indicator to a recipient.
     */
    public function sendTyping(string $sessionId, string $to, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/chatstate/typing", ['to' => $to], $token);
    }
}
