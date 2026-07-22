<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

class WebhookConfig
{
    public function __construct(
        public readonly bool $enabled,
        public readonly array $events,
        public readonly ?string $secret,
        public readonly string $url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            enabled: (bool) ($data['enabled'] ?? false),
            events: (array) ($data['events'] ?? []),
            secret: isset($data['secret']) ? (string) $data['secret'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'enabled' => $this->enabled,
            'events' => $this->events,
            'secret' => $this->secret,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
