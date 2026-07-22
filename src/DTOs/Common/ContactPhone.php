<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ContactPhone
{
    public function __construct(
        public readonly string $number,
        public readonly ?string $phoneType = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            number: isset($data['number']) ? (string) $data['number'] : null,
            phoneType: isset($data['phone_type']) ? (string) $data['phone_type'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'number' => $this->number,
            'phone_type' => $this->phoneType,
        ], fn ($val) => $val !== null);
    }
}
