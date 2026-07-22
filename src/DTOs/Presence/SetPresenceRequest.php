<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Presence;

class SetPresenceRequest
{
    public function __construct(
        public readonly mixed $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'status' => $this->status,
        ], fn ($val) => $val !== null);
    }
}
