<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Token;

class TokenSummary
{
    /**
     * @param  string[]  $sessionIds
     */
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly array $sessionIds,
        public readonly ?string $createdAt,
        public readonly ?string $expiresAt,
        public readonly bool $revoked,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (string) $data['id'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            sessionIds: array_map('strval', (array) ($data['session_ids'] ?? [])),
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            expiresAt: isset($data['expires_at']) ? (string) $data['expires_at'] : null,
            revoked: (bool) ($data['revoked'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'session_ids' => $this->sessionIds,
            'created_at' => $this->createdAt,
            'expires_at' => $this->expiresAt,
            'revoked' => $this->revoked,
        ], fn ($val) => $val !== null);
    }
}
