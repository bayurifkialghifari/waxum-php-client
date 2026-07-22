<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class AutoReconnectResponse
{
    public function __construct(
        public readonly bool $enabled,
        public readonly int $errorCount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            enabled: (bool) ($data['enabled'] ?? false),
            errorCount: isset($data['error_count']) ? (int) $data['error_count'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'enabled' => $this->enabled,
            'error_count' => $this->errorCount,
        ], fn ($val) => $val !== null);
    }
}
