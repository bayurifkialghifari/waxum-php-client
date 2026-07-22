<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

class WebhookListResponse
{
    public function __construct(
        public readonly int $count,
        public readonly array $webhooks,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            count: isset($data['count']) ? (int) $data['count'] : null,
            webhooks: (array) ($data['webhooks'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'count' => $this->count,
            'webhooks' => $this->webhooks,
        ], fn ($val) => $val !== null);
    }
}
