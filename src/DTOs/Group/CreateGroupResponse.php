<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class CreateGroupResponse
{
    public function __construct(
        public readonly string $groupJid,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            groupJid: isset($data['group_jid']) ? (string) $data['group_jid'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'group_jid' => $this->groupJid,
        ], fn ($val) => $val !== null);
    }
}
