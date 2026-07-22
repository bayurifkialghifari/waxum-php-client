<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ListRow
{
    public function __construct(
        public readonly ?string $description,
        public readonly string $rowId,
        public readonly string $title,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description: isset($data['description']) ? (string) $data['description'] : null,
            rowId: isset($data['row_id']) ? (string) $data['row_id'] : null,
            title: isset($data['title']) ? (string) $data['title'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'description' => $this->description,
            'row_id' => $this->rowId,
            'title' => $this->title,
        ], fn ($val) => $val !== null);
    }
}
