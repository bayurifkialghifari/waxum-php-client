<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ContactInfoResponse
{
    public function __construct(
        public readonly array $contacts,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            contacts: (array) ($data['contacts'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'contacts' => $this->contacts,
        ], fn ($val) => $val !== null);
    }
}
