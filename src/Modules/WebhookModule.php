<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\RegisterWebhookRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookConfigWithId;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookDlqListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Webhook\WebhookListResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class WebhookModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function list(string $sessionId, ?string $token = null): WebhookListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/webhooks", [], $token);

        return WebhookListResponse::fromArray((array) $data);
    }

    public function register(string $sessionId, RegisterWebhookRequest|array $request, ?string $token = null): WebhookConfigWithId
    {
        $payload = $request instanceof RegisterWebhookRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/webhooks", $payload, $token);

        return WebhookConfigWithId::fromArray((array) $data);
    }

    public function unregister(string $sessionId, string $webhookId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/webhooks/{$webhookId}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function reenable(string $sessionId, string $webhookId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/webhooks/{$webhookId}/enable", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function listDlq(string $sessionId, ?string $token = null): WebhookDlqListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/webhooks/dlq", [], $token);

        return WebhookDlqListResponse::fromArray((array) $data);
    }

    public function replayDlq(string $sessionId, string $entryId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/webhooks/dlq/{$entryId}/replay", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
