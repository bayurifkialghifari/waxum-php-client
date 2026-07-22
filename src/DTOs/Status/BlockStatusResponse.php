<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Status;

class BlockStatusResponse
{
    public function __construct(
        public readonly bool $isBlocked,
        public readonly string $jid,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isBlocked: (bool) ($data['is_blocked'] ?? false),
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'is_blocked' => $this->isBlocked,
            'jid' => $this->jid,
        ], fn ($val) => $val !== null);
    }
}
