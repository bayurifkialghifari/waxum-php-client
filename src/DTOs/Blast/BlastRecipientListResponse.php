<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class BlastRecipientListResponse
{
    public function __construct(
        public readonly int $count,
        public readonly array $recipients,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            count: isset($data['count']) ? (int) $data['count'] : null,
            recipients: (array) ($data['recipients'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'count' => $this->count,
            'recipients' => $this->recipients,
        ], fn ($val) => $val !== null);
    }
}
