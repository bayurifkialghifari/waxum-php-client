<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TranscriptResponse
{
    public function __construct(
        public readonly string $text,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            text: isset($data['text']) ? (string) $data['text'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'text' => $this->text,
        ], fn ($val) => $val !== null);
    }
}
