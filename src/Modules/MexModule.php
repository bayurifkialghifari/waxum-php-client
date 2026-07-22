<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class MexModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function mutate(string $sessionId, array $data, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/mex/mutate", $data, $token);
    }

    public function query(string $sessionId, array $data, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/sessions/{$sessionId}/mex/query", $data, $token);
    }
}
