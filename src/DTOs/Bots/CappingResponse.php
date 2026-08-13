<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Bots;

class CappingResponse
{
    public function __construct(
        public readonly ?string $capping,
        public readonly ?string $note,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            capping: isset($data['capping']) ? (string) $data['capping'] : null,
            note: isset($data['note']) ? (string) $data['note'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'capping' => $this->capping,
            'note' => $this->note,
        ], fn ($val) => $val !== null);
    }
}
