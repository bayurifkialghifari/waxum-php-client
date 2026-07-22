<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Nats\NatsStatusResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class NatsModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function getStatus(?string $token = null): NatsStatusResponse
    {
        $data = $this->client->get('/api/v1/nats/status', [], $token);

        return NatsStatusResponse::fromArray((array) $data);
    }

    public function listConsumers(string $streamName, ?string $token = null): mixed
    {
        return $this->client->get("/api/v1/nats/streams/{$streamName}/consumers", [], $token);
    }

    public function purgeStream(string $streamName, ?string $token = null): mixed
    {
        return $this->client->post("/api/v1/nats/streams/{$streamName}/purge", [], $token);
    }
}
