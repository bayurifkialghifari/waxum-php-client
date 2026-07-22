<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Status;

class PairStatus
{
    public function __construct(
        public readonly int $attempts,
        public readonly ?string $lastError = null,
        public readonly ?int $lastPairCodeAt = null,
        public readonly ?int $lastQrAt = null,
        public readonly ?int $pairCodeExpiresAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            attempts: isset($data['attempts']) ? (int) $data['attempts'] : null,
            lastError: isset($data['last_error']) ? (string) $data['last_error'] : null,
            lastPairCodeAt: isset($data['last_pair_code_at']) ? (int) $data['last_pair_code_at'] : null,
            lastQrAt: isset($data['last_qr_at']) ? (int) $data['last_qr_at'] : null,
            pairCodeExpiresAt: isset($data['pair_code_expires_at']) ? (int) $data['pair_code_expires_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'attempts' => $this->attempts,
            'last_error' => $this->lastError,
            'last_pair_code_at' => $this->lastPairCodeAt,
            'last_qr_at' => $this->lastQrAt,
            'pair_code_expires_at' => $this->pairCodeExpiresAt,
        ], fn ($val) => $val !== null);
    }
}
