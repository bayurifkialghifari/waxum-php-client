<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

class RegisterWebhookRequest
{
    public function __construct(
        public readonly array $events,
        public readonly ?string $secret,
        public readonly string $url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            events: (array) ($data['events'] ?? []),
            secret: isset($data['secret']) ? (string) $data['secret'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'events' => $this->events,
            'secret' => $this->secret,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
