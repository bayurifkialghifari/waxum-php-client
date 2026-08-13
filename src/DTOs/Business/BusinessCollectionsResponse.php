<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Business;

class BusinessCollectionsResponse
{
    public function __construct(
        public readonly string $collections,
        public readonly ?string $afterCursor,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            collections: isset($data['collections']) ? (string) $data['collections'] : null,
            afterCursor: isset($data['after_cursor']) ? (string) $data['after_cursor'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'collections' => $this->collections,
            'after_cursor' => $this->afterCursor,
        ], fn ($val) => $val !== null);
    }
}
