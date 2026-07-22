<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class BlastJobListResponse
{
    public function __construct(
        public readonly int $count,
        public readonly array $jobs,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            count: isset($data['count']) ? (int) $data['count'] : null,
            jobs: (array) ($data['jobs'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'count' => $this->count,
            'jobs' => $this->jobs,
        ], fn ($val) => $val !== null);
    }
}
