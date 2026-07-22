<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class StoredContact
{
    public function __construct(
        public readonly ?string $businessName,
        public readonly ?string $firstName,
        public readonly ?string $fullName,
        public readonly string $jid,
        public readonly ?string $lidJid,
        public readonly ?string $phone,
        public readonly ?string $pushName,
        public readonly string $source,
        public readonly ?string $updatedAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            businessName: isset($data['business_name']) ? (string) $data['business_name'] : null,
            firstName: isset($data['first_name']) ? (string) $data['first_name'] : null,
            fullName: isset($data['full_name']) ? (string) $data['full_name'] : null,
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            lidJid: isset($data['lid_jid']) ? (string) $data['lid_jid'] : null,
            phone: isset($data['phone']) ? (string) $data['phone'] : null,
            pushName: isset($data['push_name']) ? (string) $data['push_name'] : null,
            source: isset($data['source']) ? (string) $data['source'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'business_name' => $this->businessName,
            'first_name' => $this->firstName,
            'full_name' => $this->fullName,
            'jid' => $this->jid,
            'lid_jid' => $this->lidJid,
            'phone' => $this->phone,
            'push_name' => $this->pushName,
            'source' => $this->source,
            'updated_at' => $this->updatedAt,
        ], fn ($val) => $val !== null);
    }
}
