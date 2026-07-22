<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class CreateBlastResponse
{
    public function __construct(
        public readonly string $jobId,
        public readonly int $skippedDup,
        public readonly string $status,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            jobId: isset($data['job_id']) ? (string) $data['job_id'] : null,
            skippedDup: isset($data['skipped_dup']) ? (int) $data['skipped_dup'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
            total: isset($data['total']) ? (int) $data['total'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'job_id' => $this->jobId,
            'skipped_dup' => $this->skippedDup,
            'status' => $this->status,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
