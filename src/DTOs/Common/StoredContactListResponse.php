<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class StoredContactListResponse
{
    public function __construct(
        public readonly array $contacts,
        public readonly int $limit,
        public readonly int $offset,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            contacts: (array) ($data['contacts'] ?? []),
            limit: isset($data['limit']) ? (int) $data['limit'] : null,
            offset: isset($data['offset']) ? (int) $data['offset'] : null,
            total: isset($data['total']) ? (int) $data['total'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'contacts' => $this->contacts,
            'limit' => $this->limit,
            'offset' => $this->offset,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
