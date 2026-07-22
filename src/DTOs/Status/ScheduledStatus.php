<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Status;

class ScheduledStatus
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
