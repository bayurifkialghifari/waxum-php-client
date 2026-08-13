<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Fleet\FleetStats;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ReadyzResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ReenableCircuitsResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Fleet\ServerInfo;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class FleetModule
{
    public function __construct(protected WaxumApiClient $client) {}

    /**
     * Server metadata: version + self-detected geo location.
     */
    public function info(?string $token = null): ServerInfo
    {
        $data = $this->client->get('/api/v1/info', [], $token);

        return ServerInfo::fromArray((array) $data);
    }

    /**
     * Fleet-wide counters (sessions, webhooks, event rate, uptime).
     */
    public function stats(?string $token = null): FleetStats
    {
        $data = $this->client->get('/api/v1/stats', [], $token);

        return FleetStats::fromArray((array) $data);
    }

    /**
     * Re-enable every webhook circuit breaker that is currently open.
     */
    public function reenableAllWebhooks(?string $token = null): ReenableCircuitsResponse
    {
        $data = $this->client->post('/api/v1/webhooks/reenable-all', [], $token);

        return ReenableCircuitsResponse::fromArray((array) $data);
    }

    /**
     * DB-free static probe used by the Docker HEALTHCHECK. Returns "OK".
     */
    public function health(?string $token = null): string
    {
        return trim($this->client->requestRaw('GET', '/health', [], $token)->body());
    }

    /**
     * Liveness probe. Returns "OK".
     */
    public function live(?string $token = null): string
    {
        return trim($this->client->requestRaw('GET', '/livez', [], $token)->body());
    }

    /**
     * Readiness probe: DB pool check + registered session runtimes.
     */
    public function ready(?string $token = null): ReadyzResponse
    {
        $data = $this->client->get('/readyz', [], $token);

        return ReadyzResponse::fromArray((array) $data);
    }
}
