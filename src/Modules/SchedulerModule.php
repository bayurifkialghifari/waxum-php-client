<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\ScheduledListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class SchedulerModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function listAll(?string $session = null, ?string $status = null, ?string $token = null): ScheduledListResponse
    {
        $data = $this->client->get('/api/v1/scheduled', array_filter([
            'session' => $session,
            'status' => $status,
        ]), $token);

        return ScheduledListResponse::fromArray((array) $data);
    }

    public function listSessionScheduled(string $sessionId, ?string $status = null, ?string $token = null): ScheduledListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/scheduled", array_filter([
            'status' => $status,
        ]), $token);

        return ScheduledListResponse::fromArray((array) $data);
    }

    public function cancel(string $sessionId, string $id, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/scheduled/{$id}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
