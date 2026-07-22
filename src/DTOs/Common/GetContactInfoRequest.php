<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class GetContactInfoRequest
{
    public function __construct(
        public readonly array $phones,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            phones: (array) ($data['phones'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'phones' => $this->phones,
        ], fn ($val) => $val !== null);
    }
}
