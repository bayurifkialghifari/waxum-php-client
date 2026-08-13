<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Fleet;

class ReenableCircuitsResponse
{
    /**
     * @param  string[]  $reenabled
     */
    public function __construct(
        public readonly array $reenabled,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            reenabled: array_map('strval', (array) ($data['reenabled'] ?? [])),
            total: (int) ($data['total'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'reenabled' => $this->reenabled,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
