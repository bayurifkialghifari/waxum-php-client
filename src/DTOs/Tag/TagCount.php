<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Tag;

class TagCount
{
    public function __construct(
        public readonly ?string $tag,
        public readonly int $sessionCount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tag: isset($data['tag']) ? (string) $data['tag'] : null,
            sessionCount: (int) ($data['session_count'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'tag' => $this->tag,
            'session_count' => $this->sessionCount,
        ], fn ($val) => $val !== null);
    }
}
