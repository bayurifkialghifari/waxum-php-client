<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class GroupListResponse
{
    public function __construct(
        public readonly array $groups,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            groups: (array) ($data['groups'] ?? []),
            total: isset($data['total']) ? (int) $data['total'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'groups' => $this->groups,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
