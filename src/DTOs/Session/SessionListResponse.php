<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class SessionListResponse
{
    public function __construct(
        public readonly array $sessions,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sessions: (array) ($data['sessions'] ?? []),
            total: isset($data['total']) ? (int) $data['total'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sessions' => $this->sessions,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
