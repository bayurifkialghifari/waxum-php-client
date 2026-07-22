<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TcTokenItem
{
    public function __construct(
        public readonly string $jid,
        public readonly int $timestamp,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            timestamp: isset($data['timestamp']) ? (int) $data['timestamp'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'jid' => $this->jid,
            'timestamp' => $this->timestamp,
        ], fn ($val) => $val !== null);
    }
}
