<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class CreateBlastRequest
{
    public function __construct(
        public readonly mixed $body,
        public readonly ?bool $dedupAcrossJobs,
        public readonly ?int $delayMs,
        public readonly string $endpoint,
        public readonly ?int $jitterMs,
        public readonly ?int $maxAttempts,
        public readonly array $recipients,
        public readonly ?string $sendAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            body: $data['body'] ?? null,
            dedupAcrossJobs: (bool) ($data['dedup_across_jobs'] ?? false),
            delayMs: isset($data['delay_ms']) ? (int) $data['delay_ms'] : null,
            endpoint: isset($data['endpoint']) ? (string) $data['endpoint'] : null,
            jitterMs: isset($data['jitter_ms']) ? (int) $data['jitter_ms'] : null,
            maxAttempts: isset($data['max_attempts']) ? (int) $data['max_attempts'] : null,
            recipients: (array) ($data['recipients'] ?? []),
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body' => $this->body,
            'dedup_across_jobs' => $this->dedupAcrossJobs,
            'delay_ms' => $this->delayMs,
            'endpoint' => $this->endpoint,
            'jitter_ms' => $this->jitterMs,
            'max_attempts' => $this->maxAttempts,
            'recipients' => $this->recipients,
            'send_at' => $this->sendAt,
        ], fn ($val) => $val !== null);
    }
}
