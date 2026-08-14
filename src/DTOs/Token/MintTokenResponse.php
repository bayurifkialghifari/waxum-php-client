<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Token;

class MintTokenResponse
{
    /**
     * @param  string[]  $sessionIds
     */
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $token,
        public readonly ?string $name,
        public readonly array $sessionIds,
        public readonly ?int $expiresAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (string) $data['id'] : null,
            token: isset($data['token']) ? (string) $data['token'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            sessionIds: array_map('strval', (array) ($data['session_ids'] ?? [])),
            expiresAt: isset($data['expires_at']) ? (int) $data['expires_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'token' => $this->token,
            'name' => $this->name,
            'session_ids' => $this->sessionIds,
            'expires_at' => $this->expiresAt,
        ], fn ($val) => $val !== null);
    }
}
