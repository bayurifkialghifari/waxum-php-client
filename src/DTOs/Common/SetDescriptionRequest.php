<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SetDescriptionRequest
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $prevId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description: isset($data['description']) ? (string) $data['description'] : null,
            prevId: isset($data['prev_id']) ? (string) $data['prev_id'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'description' => $this->description,
            'prev_id' => $this->prevId,
        ], fn ($val) => $val !== null);
    }
}
