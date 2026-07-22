<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class FakeReplyConfig
{
    public function __construct(
        public readonly ?string $body,
        public readonly ?string $participant,
        public readonly ?string $stanzaId,
        public readonly ?string $title,
        public readonly string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            body: isset($data['body']) ? (string) $data['body'] : null,
            participant: isset($data['participant']) ? (string) $data['participant'] : null,
            stanzaId: isset($data['stanza_id']) ? (string) $data['stanza_id'] : null,
            title: isset($data['title']) ? (string) $data['title'] : null,
            type: isset($data['type']) ? (string) $data['type'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body' => $this->body,
            'participant' => $this->participant,
            'stanza_id' => $this->stanzaId,
            'title' => $this->title,
            'type' => $this->type,
        ], fn ($val) => $val !== null);
    }
}
