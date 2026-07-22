<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ContactCard
{
    public function __construct(
        public readonly string $displayName,
        public readonly ?string $organization,
        public readonly array $phones,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            displayName: isset($data['display_name']) ? (string) $data['display_name'] : null,
            organization: isset($data['organization']) ? (string) $data['organization'] : null,
            phones: (array) ($data['phones'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'display_name' => $this->displayName,
            'organization' => $this->organization,
            'phones' => $this->phones,
        ], fn ($val) => $val !== null);
    }
}
