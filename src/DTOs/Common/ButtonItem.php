<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ButtonItem
{
    public function __construct(
        public readonly string $buttonId,
        public readonly string $displayText,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            buttonId: isset($data['button_id']) ? (string) $data['button_id'] : null,
            displayText: isset($data['display_text']) ? (string) $data['display_text'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'button_id' => $this->buttonId,
            'display_text' => $this->displayText,
        ], fn ($val) => $val !== null);
    }
}
