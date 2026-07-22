<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class WhatsAppCheckResult
{
    public function __construct(
        public readonly bool $isRegistered,
        public readonly ?string $jid,
        public readonly string $phone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isRegistered: (bool) ($data['is_registered'] ?? false),
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            phone: isset($data['phone']) ? (string) $data['phone'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'is_registered' => $this->isRegistered,
            'jid' => $this->jid,
            'phone' => $this->phone,
        ], fn ($val) => $val !== null);
    }
}
