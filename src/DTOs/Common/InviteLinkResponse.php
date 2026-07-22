<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class InviteLinkResponse
{
    public function __construct(
        public readonly string $inviteLink,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            inviteLink: isset($data['invite_link']) ? (string) $data['invite_link'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'invite_link' => $this->inviteLink,
        ], fn ($val) => $val !== null);
    }
}
