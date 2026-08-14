<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class SessionMessagesResponse
{
    public function __construct(
        public readonly int $count,
        public readonly array $messages,
        public readonly ?int $nextCursor = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            count: isset($data['count']) ? (int) $data['count'] : null,
            messages: (array) ($data['messages'] ?? []),
            nextCursor: isset($data['next_cursor']) ? (int) $data['next_cursor'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'count' => $this->count,
            'messages' => $this->messages,
            'next_cursor' => $this->nextCursor,
        ], fn ($val) => $val !== null);
    }
}
