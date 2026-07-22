<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Media;

class DownloadMediaResponse
{
    public function __construct(
        public readonly string $data,
    ) {}

    public static function fromArray(string $data): self
    {
        return new self(
            data: $data ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'data' => $this->data,
        ], fn ($val) => $val !== null);
    }
}
