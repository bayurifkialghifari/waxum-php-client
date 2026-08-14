<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

class WebhookDlqEntry
{
    public function __construct(
        public readonly int $attempts,
        public readonly string $event,
        public readonly int $failedAt,
        public readonly string $id,
        public readonly string $lastError,
        public readonly string $payload,
        public readonly string $sessionId,
        public readonly string $webhookUrl,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            attempts: isset($data['attempts']) ? (int) $data['attempts'] : null,
            event: isset($data['event']) ? (string) $data['event'] : null,
            failedAt: isset($data['failed_at']) ? (int) $data['failed_at'] : null,
            id: isset($data['id']) ? (string) $data['id'] : null,
            lastError: isset($data['last_error']) ? (string) $data['last_error'] : null,
            payload: isset($data['payload']) ? (string) $data['payload'] : null,
            sessionId: isset($data['session_id']) ? (string) $data['session_id'] : null,
            webhookUrl: isset($data['webhook_url']) ? (string) $data['webhook_url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'attempts' => $this->attempts,
            'event' => $this->event,
            'failed_at' => $this->failedAt,
            'id' => $this->id,
            'last_error' => $this->lastError,
            'payload' => $this->payload,
            'session_id' => $this->sessionId,
            'webhook_url' => $this->webhookUrl,
        ], fn ($val) => $val !== null);
    }
}
