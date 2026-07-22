<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class HistorySyncRequest
{
    public function __construct(
        public readonly bool $skip,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            skip: (bool) ($data['skip'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'skip' => $this->skip,
        ], fn ($val) => $val !== null);
    }
}
