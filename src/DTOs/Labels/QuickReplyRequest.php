<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Labels;

class QuickReplyRequest
{
    public function __construct(
        public readonly string $id,
        public readonly string $shortcut,
        public readonly string $message,
        public readonly ?array $keywords = null,
        public readonly ?int $count = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (string) $data['id'] : null,
            shortcut: isset($data['shortcut']) ? (string) $data['shortcut'] : null,
            message: isset($data['message']) ? (string) $data['message'] : null,
            keywords: isset($data['keywords']) ? (array) $data['keywords'] : null,
            count: isset($data['count']) ? (int) $data['count'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'shortcut' => $this->shortcut,
            'message' => $this->message,
            'keywords' => $this->keywords,
            'count' => $this->count,
        ], fn ($val) => $val !== null);
    }
}
