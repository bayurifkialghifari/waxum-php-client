<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class RequestPaymentRequest
{
    public function __construct(
        public readonly int $amount1000,
        public readonly string $currencyCode,
        public readonly ?int $expiryTimestamp,
        public readonly ?string $note,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            amount1000: isset($data['amount1000']) ? (int) $data['amount1000'] : null,
            currencyCode: isset($data['currency_code']) ? (string) $data['currency_code'] : null,
            expiryTimestamp: isset($data['expiry_timestamp']) ? (int) $data['expiry_timestamp'] : null,
            note: isset($data['note']) ? (string) $data['note'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'amount1000' => $this->amount1000,
            'currency_code' => $this->currencyCode,
            'expiry_timestamp' => $this->expiryTimestamp,
            'note' => $this->note,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
