<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Privacy;

class PrivacySettingItem
{
    public function __construct(
        public readonly string $category,
        public readonly string $value,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            category: isset($data['category']) ? (string) $data['category'] : null,
            value: isset($data['value']) ? (string) $data['value'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'category' => $this->category,
            'value' => $this->value,
        ], fn ($val) => $val !== null);
    }
}
