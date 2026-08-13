<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class PurgeResponse
{
    /**
     * @param  string[]  $purged
     */
    public function __construct(
        public readonly string $filter,
        public readonly int $days,
        public readonly bool $dryRun,
        public readonly array $purged,
        public readonly int $kept,
        public readonly int $totalBefore,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            filter: (string) ($data['filter'] ?? ''),
            days: (int) ($data['days'] ?? 0),
            dryRun: (bool) ($data['dry_run'] ?? false),
            purged: array_map('strval', (array) ($data['purged'] ?? [])),
            kept: (int) ($data['kept'] ?? 0),
            totalBefore: (int) ($data['total_before'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'filter' => $this->filter,
            'days' => $this->days,
            'dry_run' => $this->dryRun,
            'purged' => $this->purged,
            'kept' => $this->kept,
            'total_before' => $this->totalBefore,
        ], fn ($val) => $val !== null);
    }
}
