<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class CreateGroupRequest
{
    public function __construct(
        public readonly mixed $memberAddMode = null,
        public readonly mixed $memberLinkMode = null,
        public readonly mixed $membershipApprovalMode = null,
        public readonly string $name,
        public readonly array $participants,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            memberAddMode: $data['member_add_mode'] ?? null,
            memberLinkMode: $data['member_link_mode'] ?? null,
            membershipApprovalMode: $data['membership_approval_mode'] ?? null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            participants: (array) ($data['participants'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'member_add_mode' => $this->memberAddMode,
            'member_link_mode' => $this->memberLinkMode,
            'membership_approval_mode' => $this->membershipApprovalMode,
            'name' => $this->name,
            'participants' => $this->participants,
        ], fn ($val) => $val !== null);
    }
}
