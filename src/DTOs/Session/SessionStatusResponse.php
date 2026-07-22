<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

use Bayurifkialghifari\WaxumApi\DTOs\Status\PairStatus;

class SessionStatusResponse
{
    public function __construct(
        public readonly bool $isLoggedIn,
        public readonly ?PairStatus $pair,
        public readonly ?string $phoneNumber,
        public readonly ?string $pushName,
        public readonly mixed $status,
    ) {}

    public static function fromArray(array $data): self
    {
        $pairData = $data['pair'] ?? null;

        return new self(
            isLoggedIn: (bool) ($data['is_logged_in'] ?? false),
            pair: is_array($pairData)
                ? PairStatus::fromArray($pairData)
                : ($pairData instanceof PairStatus ? $pairData : null),
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            pushName: isset($data['push_name']) ? (string) $data['push_name'] : null,
            status: $data['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'is_logged_in' => $this->isLoggedIn,
            'pair' => $this->pair?->toArray(),
            'phone_number' => $this->phoneNumber,
            'push_name' => $this->pushName,
            'status' => $this->status,
        ], fn ($val) => $val !== null);
    }
}
