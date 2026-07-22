<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class AutoReconnectRequest
{
    public function __construct(
        public readonly bool $enabled,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            enabled: (bool) ($data['enabled'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'enabled' => $this->enabled,
        ], fn ($val) => $val !== null);
    }
}
