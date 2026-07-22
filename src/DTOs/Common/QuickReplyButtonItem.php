<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class QuickReplyButtonItem
{
    public function __construct(
        public readonly string $displayText,
        public readonly string $id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            displayText: isset($data['display_text']) ? (string) $data['display_text'] : null,
            id: isset($data['id']) ? (string) $data['id'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'display_text' => $this->displayText,
            'id' => $this->id,
        ], fn ($val) => $val !== null);
    }
}
