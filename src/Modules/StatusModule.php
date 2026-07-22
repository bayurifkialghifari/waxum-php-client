<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class StatusModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function sendReaction(string $sessionId, array $data, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/status/react", $data, $token);
    }
}
