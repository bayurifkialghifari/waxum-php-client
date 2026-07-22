<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class BlockRequest
{
    public function __construct(
        public readonly string $jid,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'jid' => $this->jid,
        ], fn ($val) => $val !== null);
    }
}
