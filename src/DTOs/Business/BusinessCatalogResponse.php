<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Business;

class BusinessCatalogResponse
{
    public function __construct(
        public readonly string $products,
        public readonly ?string $afterCursor,
        public readonly ?string $beforeCursor,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            products: isset($data['products']) ? (string) $data['products'] : null,
            afterCursor: isset($data['after_cursor']) ? (string) $data['after_cursor'] : null,
            beforeCursor: isset($data['before_cursor']) ? (string) $data['before_cursor'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'products' => $this->products,
            'after_cursor' => $this->afterCursor,
            'before_cursor' => $this->beforeCursor,
        ], fn ($val) => $val !== null);
    }
}
