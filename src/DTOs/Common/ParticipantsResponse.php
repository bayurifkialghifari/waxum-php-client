<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ParticipantsResponse
{
    public function __construct(
        public readonly array $results,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            results: (array) ($data['results'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'results' => $this->results,
        ], fn ($val) => $val !== null);
    }
}
