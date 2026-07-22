<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TcTokenListResponse
{
    public function __construct(
        public readonly array $jids,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            jids: (array) ($data['jids'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'jids' => $this->jids,
        ], fn ($val) => $val !== null);
    }
}
