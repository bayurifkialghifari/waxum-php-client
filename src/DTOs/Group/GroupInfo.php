<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Group;

class GroupInfo
{
    public function __construct(
        public readonly string $addressingMode,
        public readonly string $jid,
        public readonly array $participants,
        public readonly string $subject,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            addressingMode: isset($data['addressing_mode']) ? (string) $data['addressing_mode'] : null,
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            participants: (array) ($data['participants'] ?? []),
            subject: isset($data['subject']) ? (string) $data['subject'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'addressing_mode' => $this->addressingMode,
            'jid' => $this->jid,
            'participants' => $this->participants,
            'subject' => $this->subject,
        ], fn ($val) => $val !== null);
    }
}
