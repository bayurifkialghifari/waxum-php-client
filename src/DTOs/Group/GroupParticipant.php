<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class GroupParticipant
{
    public function __construct(
        public readonly string $jid,
        public readonly ?string $phoneNumber,
        public readonly mixed $role,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            role: $data['role'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'jid' => $this->jid,
            'phone_number' => $this->phoneNumber,
            'role' => $this->role,
        ], fn ($val) => $val !== null);
    }
}
