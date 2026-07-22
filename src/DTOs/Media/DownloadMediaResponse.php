<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Media;

class DownloadMediaResponse
{
    public function __construct(
        public readonly string $data,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            data: isset($data['data']) ? (string) $data['data'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'data' => $this->data,
        ], fn ($val) => $val !== null);
    }
}
