<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class SetGroupSettingsRequest
{
    public function __construct(
        public readonly mixed $memberAddMode = null,
        public readonly mixed $memberLinkMode = null,
        public readonly mixed $membershipApprovalMode = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            memberAddMode: $data['member_add_mode'] ?? null,
            memberLinkMode: $data['member_link_mode'] ?? null,
            membershipApprovalMode: $data['membership_approval_mode'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'member_add_mode' => $this->memberAddMode,
            'member_link_mode' => $this->memberLinkMode,
            'membership_approval_mode' => $this->membershipApprovalMode,
        ], fn ($val) => $val !== null);
    }
}
