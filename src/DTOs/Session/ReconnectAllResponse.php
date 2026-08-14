<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class ReconnectAllResponse
{
    /**
     * @param  string[]  $scheduled
     * @param  string[]  $skipped
     */
    public function __construct(
        public readonly array $scheduled,
        public readonly array $skipped,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            scheduled: array_map('strval', (array) ($data['scheduled'] ?? [])),
            skipped: array_map('strval', (array) ($data['skipped'] ?? [])),
            total: (int) ($data['total'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'scheduled' => $this->scheduled,
            'skipped' => $this->skipped,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
