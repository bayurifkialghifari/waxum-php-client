<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Tag;

class TagMutateResponse
{
    /**
     * @param  string[]  $tags
     */
    public function __construct(
        public readonly ?string $sessionId,
        public readonly ?string $tag,
        public readonly bool $changed,
        public readonly array $tags,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sessionId: isset($data['session_id']) ? (string) $data['session_id'] : null,
            tag: isset($data['tag']) ? (string) $data['tag'] : null,
            changed: (bool) ($data['changed'] ?? false),
            tags: array_map('strval', (array) ($data['tags'] ?? [])),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'session_id' => $this->sessionId,
            'tag' => $this->tag,
            'changed' => $this->changed,
            'tags' => $this->tags,
        ], fn ($val) => $val !== null);
    }
}
