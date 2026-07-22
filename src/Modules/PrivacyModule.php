<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class PrivacyModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function getSettings(string $sessionId, ?string $token = null): mixed
    {
        return $this->client->get("/api/v1/sessions/{$sessionId}/privacy/settings", [], $token);
    }
}
