<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TcTokenGetResponse
{
    public function __construct(
        public readonly bool $found,
        public readonly string $jid,
        public readonly ?int $senderTimestamp = null,
        public readonly ?int $tokenTimestamp = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            found: (bool) ($data['found'] ?? false),
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            senderTimestamp: isset($data['sender_timestamp']) ? (int) $data['sender_timestamp'] : null,
            tokenTimestamp: isset($data['token_timestamp']) ? (int) $data['token_timestamp'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'found' => $this->found,
            'jid' => $this->jid,
            'sender_timestamp' => $this->senderTimestamp,
            'token_timestamp' => $this->tokenTimestamp,
        ], fn ($val) => $val !== null);
    }
}
