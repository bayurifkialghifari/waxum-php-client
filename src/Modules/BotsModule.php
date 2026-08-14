<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Bots\BotListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Bots\CappingResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class BotsModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function bots(string $sessionId, ?string $token = null): BotListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/bots", [], $token);

        return BotListResponse::fromArray((array) $data);
    }

    public function capping(string $sessionId, ?string $token = null): CappingResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/capping", [], $token);

        return CappingResponse::fromArray((array) $data);
    }
}
