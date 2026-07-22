<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class SessionInfo
{
    public function __construct(
        public readonly ?int $createdAt,
        public readonly ?string $id,
        public readonly bool $isLoggedIn,
        public readonly ?int $lastConnectedAt,
        public readonly ?string $name,
        public readonly ?string $phoneNumber,
        public readonly ?string $pushName,
        public readonly mixed $status,
        public readonly ?int $updatedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            createdAt: isset($data['created_at']) ? (int) $data['created_at'] : null,
            id: isset($data['id']) ? (string) $data['id'] : null,
            isLoggedIn: (bool) ($data['is_logged_in'] ?? false),
            lastConnectedAt: isset($data['last_connected_at']) ? (int) $data['last_connected_at'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            pushName: isset($data['push_name']) ? (string) $data['push_name'] : null,
            status: $data['status'] ?? null,
            updatedAt: isset($data['updated_at']) ? (int) $data['updated_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'created_at' => $this->createdAt,
            'id' => $this->id,
            'is_logged_in' => $this->isLoggedIn,
            'last_connected_at' => $this->lastConnectedAt,
            'name' => $this->name,
            'phone_number' => $this->phoneNumber,
            'push_name' => $this->pushName,
            'status' => $this->status,
            'updated_at' => $this->updatedAt,
        ], fn ($val) => $val !== null);
    }
}
