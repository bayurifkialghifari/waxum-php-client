<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Media;

class DownloadMediaResponse
{
    public function __construct(
        public readonly string $data,
        public readonly int $size,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            data: isset($data['data']) ? (string) $data['data'] : null,
            size: isset($data['size']) ? (int) $data['size'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'data' => $this->data,
            'size' => $this->size,
        ], fn ($val) => $val !== null);
    }
}
