<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class PresenceModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function set(string $sessionId, string $status, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/presence/set", ['status' => $status], $token);
    }

    public function subscribe(string $sessionId, string $jid, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/presence/subscribe", ['jid' => $jid], $token);
    }
}
