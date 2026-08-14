<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Token;

class MintTokenRequest
{
    /**
     * @param  string[]  $sessionIds
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly array $sessionIds = [],
        public readonly ?int $expiresInHours = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? (string) $data['name'] : null,
            sessionIds: array_map('strval', (array) ($data['session_ids'] ?? [])),
            expiresInHours: isset($data['expires_in_hours']) ? (int) $data['expires_in_hours'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'session_ids' => $this->sessionIds,
            'expires_in_hours' => $this->expiresInHours,
        ], fn ($val) => $val !== null);
    }
}
