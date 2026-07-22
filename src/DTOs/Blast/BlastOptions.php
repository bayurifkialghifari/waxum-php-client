<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class BlastOptions
{
    public function __construct(
        public readonly bool $dedupAcrossJobs,
        public readonly int $delayMs,
        public readonly int $jitterMs,
        public readonly int $maxAttempts,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            dedupAcrossJobs: (bool) ($data['dedup_across_jobs'] ?? false),
            delayMs: isset($data['delay_ms']) ? (int) $data['delay_ms'] : null,
            jitterMs: isset($data['jitter_ms']) ? (int) $data['jitter_ms'] : null,
            maxAttempts: isset($data['max_attempts']) ? (int) $data['max_attempts'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'dedup_across_jobs' => $this->dedupAcrossJobs,
            'delay_ms' => $this->delayMs,
            'jitter_ms' => $this->jitterMs,
            'max_attempts' => $this->maxAttempts,
        ], fn ($val) => $val !== null);
    }
}
