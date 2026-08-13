<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class NewsletterMetadataResponse
{
    public function __construct(
        public readonly string $metadata,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            metadata: isset($data['metadata']) ? (string) $data['metadata'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'metadata' => $this->metadata,
        ], fn ($val) => $val !== null);
    }
}
