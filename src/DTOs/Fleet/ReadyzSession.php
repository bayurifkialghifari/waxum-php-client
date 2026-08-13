<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Fleet;

class ReadyzSession
{
    public function __construct(
        public readonly ?string $id,
        public readonly mixed $status,
        public readonly bool $socketAlive,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (string) $data['id'] : null,
            status: $data['status'] ?? null,
            socketAlive: (bool) ($data['socket_alive'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'status' => $this->status,
            'socket_alive' => $this->socketAlive,
        ], fn ($val) => $val !== null);
    }
}
