<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TcTokenPruneResponse
{
    public function __construct(
        public readonly int $prunedCount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            prunedCount: isset($data['pruned_count']) ? (int) $data['pruned_count'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'pruned_count' => $this->prunedCount,
        ], fn ($val) => $val !== null);
    }
}
