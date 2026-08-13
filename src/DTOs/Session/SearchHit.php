<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class SearchHit
{
    /**
     * @param  string[]  $matchOn
     */
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $phoneNumber,
        public readonly ?string $pushName,
        public readonly mixed $status,
        public readonly bool $isLoggedIn,
        public readonly array $matchOn,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (string) $data['id'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            pushName: isset($data['push_name']) ? (string) $data['push_name'] : null,
            status: $data['status'] ?? null,
            isLoggedIn: (bool) ($data['is_logged_in'] ?? false),
            matchOn: array_map('strval', (array) ($data['match_on'] ?? [])),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phoneNumber,
            'push_name' => $this->pushName,
            'status' => $this->status,
            'is_logged_in' => $this->isLoggedIn,
            'match_on' => $this->matchOn,
        ], fn ($val) => $val !== null);
    }
}
