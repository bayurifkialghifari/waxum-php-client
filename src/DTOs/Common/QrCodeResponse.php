<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class QrCodeResponse
{
    public function __construct(
        public readonly array $qrCodes,
        public readonly mixed $status,
        public readonly int $timeoutSeconds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            qrCodes: (array) ($data['qr_codes'] ?? []),
            status: $data['status'] ?? null,
            timeoutSeconds: isset($data['timeout_seconds']) ? (int) $data['timeout_seconds'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'qr_codes' => $this->qrCodes,
            'status' => $this->status,
            'timeout_seconds' => $this->timeoutSeconds,
        ], fn ($val) => $val !== null);
    }
}
