<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ParticipantsRequest
{
    public function __construct(
        public readonly array $participants,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            participants: (array) ($data['participants'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'participants' => $this->participants,
        ], fn ($val) => $val !== null);
    }
}
