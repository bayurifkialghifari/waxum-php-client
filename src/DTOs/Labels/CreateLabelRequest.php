<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Labels;

class CreateLabelRequest
{
    public function __construct(
        public readonly string $labelId,
        public readonly string $name,
        public readonly ?string $color = null,
        public readonly ?int $colorId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            labelId: isset($data['label_id']) ? (string) $data['label_id'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            color: isset($data['color']) ? (string) $data['color'] : null,
            colorId: isset($data['color_id']) ? (int) $data['color_id'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'label_id' => $this->labelId,
            'name' => $this->name,
            'color' => $this->color,
            'color_id' => $this->colorId,
        ], fn ($val) => $val !== null);
    }
}
