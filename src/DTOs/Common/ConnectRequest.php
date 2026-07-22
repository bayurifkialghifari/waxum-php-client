<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ConnectRequest
{
    public function __construct(
        public readonly mixed $device = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            device: $data['device'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'device' => $this->device,
        ], fn ($val) => $val !== null);
    }
}
