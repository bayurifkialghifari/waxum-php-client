<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class BlastJob
{
    public function __construct(
        public readonly string $createdAt,
        public readonly int $dlqCount,
        public readonly string $endpoint,
        public readonly int $failedCount,
        public readonly ?string $finishedAt,
        public readonly string $id,
        public readonly mixed $options,
        public readonly ?string $sendAt,
        public readonly int $sentCount,
        public readonly string $sessionId,
        public readonly int $skippedDupCount,
        public readonly ?string $startedAt,
        public readonly mixed $status,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            dlqCount: isset($data['dlq_count']) ? (int) $data['dlq_count'] : null,
            endpoint: isset($data['endpoint']) ? (string) $data['endpoint'] : null,
            failedCount: isset($data['failed_count']) ? (int) $data['failed_count'] : null,
            finishedAt: isset($data['finished_at']) ? (string) $data['finished_at'] : null,
            id: isset($data['id']) ? (string) $data['id'] : null,
            options: $data['options'] ?? null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            sentCount: isset($data['sent_count']) ? (int) $data['sent_count'] : null,
            sessionId: isset($data['session_id']) ? (string) $data['session_id'] : null,
            skippedDupCount: isset($data['skipped_dup_count']) ? (int) $data['skipped_dup_count'] : null,
            startedAt: isset($data['started_at']) ? (string) $data['started_at'] : null,
            status: $data['status'] ?? null,
            total: isset($data['total']) ? (int) $data['total'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'created_at' => $this->createdAt,
            'dlq_count' => $this->dlqCount,
            'endpoint' => $this->endpoint,
            'failed_count' => $this->failedCount,
            'finished_at' => $this->finishedAt,
            'id' => $this->id,
            'options' => $this->options,
            'send_at' => $this->sendAt,
            'sent_count' => $this->sentCount,
            'session_id' => $this->sessionId,
            'skipped_dup_count' => $this->skippedDupCount,
            'started_at' => $this->startedAt,
            'status' => $this->status,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
