<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class GroupInfoCached
{
    public function __construct(
        public readonly string $addressingMode,
        public readonly array $participants,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            addressingMode: isset($data['addressing_mode']) ? (string) $data['addressing_mode'] : null,
            participants: (array) ($data['participants'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'addressing_mode' => $this->addressingMode,
            'participants' => $this->participants,
        ], fn ($val) => $val !== null);
    }
}
