<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

use Bayurifkialghifari\WaxumApi\DTOs\Status\PairStatus;

class SessionStatusResponse
{
    public function __construct(
        public readonly bool $isLoggedIn,
        public readonly ?PairStatus $pair,
        public readonly bool $paused,
        public readonly ?string $phoneNumber,
        public readonly ?string $pushName,
        public readonly bool $socketAlive,
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
            paused: (bool) ($data['paused'] ?? false),
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            pushName: isset($data['push_name']) ? (string) $data['push_name'] : null,
            socketAlive: (bool) ($data['socket_alive'] ?? false),
            status: $data['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'is_logged_in' => $this->isLoggedIn,
            'pair' => $this->pair?->toArray(),
            'paused' => $this->paused,
            'phone_number' => $this->phoneNumber,
            'push_name' => $this->pushName,
            'socket_alive' => $this->socketAlive,
            'status' => $this->status,
        ], fn ($val) => $val !== null);
    }
}
