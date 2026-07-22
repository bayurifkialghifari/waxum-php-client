<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

class WebhookConfigWithId
{
    public function __construct(
        public readonly bool $enabled,
        public readonly array $events,
        public readonly string $id,
        public readonly ?string $secret,
        public readonly string $url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            enabled: (bool) ($data['enabled'] ?? false),
            events: (array) ($data['events'] ?? []),
            id: isset($data['id']) ? (string) $data['id'] : null,
            secret: isset($data['secret']) ? (string) $data['secret'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'enabled' => $this->enabled,
            'events' => $this->events,
            'id' => $this->id,
            'secret' => $this->secret,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
