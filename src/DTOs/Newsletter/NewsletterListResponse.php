<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class NewsletterListResponse
{
    public function __construct(
        public readonly string $newsletters,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            newsletters: isset($data['newsletters']) ? (string) $data['newsletters'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'newsletters' => $this->newsletters,
        ], fn ($val) => $val !== null);
    }
}
