<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class UserInfo
{
    public function __construct(
        public readonly bool $isBusiness,
        public readonly string $jid,
        public readonly ?string $lid = null,
        public readonly ?string $pictureId = null,
        public readonly ?string $status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            isBusiness: (bool) ($data['is_business'] ?? false),
            jid: isset($data['jid']) ? (string) $data['jid'] : null,
            lid: isset($data['lid']) ? (string) $data['lid'] : null,
            pictureId: isset($data['picture_id']) ? (string) $data['picture_id'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'is_business' => $this->isBusiness,
            'jid' => $this->jid,
            'lid' => $this->lid,
            'picture_id' => $this->pictureId,
            'status' => $this->status,
        ], fn ($val) => $val !== null);
    }
}
