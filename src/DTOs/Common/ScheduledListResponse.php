<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ScheduledListResponse
{
    public function __construct(
        public readonly int $count,
        public readonly array $messages,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            count: isset($data['count']) ? (int) $data['count'] : null,
            messages: (array) ($data['messages'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'count' => $this->count,
            'messages' => $this->messages,
        ], fn ($val) => $val !== null);
    }
}
