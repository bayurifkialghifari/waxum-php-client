<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Nats;

class NatsStatusResponse
{
    public function __construct(
        public readonly bool $connected,
        public readonly bool $enabled,
        public readonly mixed $eventsStream = null,
        public readonly mixed $sendStream = null,
        public readonly ?string $url = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            connected: (bool) ($data['connected'] ?? false),
            enabled: (bool) ($data['enabled'] ?? false),
            eventsStream: $data['events_stream'] ?? null,
            sendStream: $data['send_stream'] ?? null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'connected' => $this->connected,
            'enabled' => $this->enabled,
            'events_stream' => $this->eventsStream,
            'send_stream' => $this->sendStream,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
