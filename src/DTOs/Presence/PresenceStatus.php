<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Presence;

class PresenceStatus
{
    public function __construct(

    ) {}

    public static function fromArray(array $data): self
    {
        return new self;
    }

    public function toArray(): array
    {
        return array_filter([

        ], fn ($val) => $val !== null);
    }
}
