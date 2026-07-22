<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ListSection
{
    public function __construct(
        public readonly array $rows,
        public readonly string $title,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rows: (array) ($data['rows'] ?? []),
            title: isset($data['title']) ? (string) $data['title'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'rows' => $this->rows,
            'title' => $this->title,
        ], fn ($val) => $val !== null);
    }
}
