<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Blast\BlastJob;
use Bayurifkialghifari\WaxumApi\DTOs\Blast\BlastJobListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Blast\BlastRecipientListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Blast\CreateBlastRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Blast\CreateBlastResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class BlastModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function listAll(?string $session = null, ?string $status = null, ?string $token = null): BlastJobListResponse
    {
        $data = $this->client->get('/api/v1/blasts', array_filter([
            'session' => $session,
            'status' => $status,
        ]), $token);

        return BlastJobListResponse::fromArray((array) $data);
    }

    public function create(string $sessionId, CreateBlastRequest|array $request, ?string $token = null): CreateBlastResponse
    {
        $payload = $request instanceof CreateBlastRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/blast", $payload, $token);

        return CreateBlastResponse::fromArray((array) $data);
    }

    public function listSessionBlasts(string $sessionId, ?string $status = null, ?string $token = null): BlastJobListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/blasts", array_filter([
            'status' => $status,
        ]), $token);

        return BlastJobListResponse::fromArray((array) $data);
    }

    public function get(string $sessionId, string $id, ?string $token = null): BlastJob
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/blasts/{$id}", [], $token);

        return BlastJob::fromArray((array) $data);
    }

    public function cancel(string $sessionId, string $id, ?string $token = null): BlastJob
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/blasts/{$id}/cancel", [], $token);

        return BlastJob::fromArray((array) $data);
    }

    public function listRecipients(
        string $sessionId,
        string $id,
        ?string $status = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $token = null
    ): BlastRecipientListResponse {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/blasts/{$id}/recipients", array_filter([
            'status' => $status,
            'limit' => $limit,
            'offset' => $offset,
        ]), $token);

        return BlastRecipientListResponse::fromArray((array) $data);
    }

    public function retry(string $sessionId, string $id, ?string $token = null): BlastJob
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/blasts/{$id}/retry", [], $token);

        return BlastJob::fromArray((array) $data);
    }
}
