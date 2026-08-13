<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Tag;

class TagListResponse
{
    /**
     * @param  string[]  $tags
     */
    public function __construct(
        public readonly ?string $sessionId,
        public readonly array $tags,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sessionId: isset($data['session_id']) ? (string) $data['session_id'] : null,
            tags: array_map('strval', (array) ($data['tags'] ?? [])),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'session_id' => $this->sessionId,
            'tags' => $this->tags,
        ], fn ($val) => $val !== null);
    }
}
