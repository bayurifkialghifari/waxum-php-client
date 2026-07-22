<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class BlocklistResponse
{
    public function __construct(
        public readonly array $blocked,
        public readonly int $count,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            blocked: (array) ($data['blocked'] ?? []),
            count: isset($data['count']) ? (int) $data['count'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'blocked' => $this->blocked,
            'count' => $this->count,
        ], fn ($val) => $val !== null);
    }
}
