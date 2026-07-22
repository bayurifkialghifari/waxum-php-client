<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ParticipantChangeResult
{
    public function __construct(
        public readonly string $jid,
        public readonly string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'jid' => $this->jid,
            'status' => $this->status,
        ], fn ($val) => $val !== null);
    }
}
