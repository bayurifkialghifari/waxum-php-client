<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class CreateSessionRequest
{
    public function __construct(
        public readonly mixed $device = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?bool $reuse = null,
        public readonly mixed $webhook = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            device: $data['device'] ?? null,
            id: isset($data['id']) ? (string) $data['id'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            reuse: isset($data['reuse']) ? (bool) $data['reuse'] : null,
            webhook: $data['webhook'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'device' => $this->device,
            'id' => $this->id,
            'name' => $this->name,
            'reuse' => $this->reuse,
            'webhook' => $this->webhook,
        ], fn ($val) => $val !== null);
    }
}
