<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendButtonsResponseRequest
{
    public function __construct(
        public readonly ?string $replyTo,
        public readonly string $selectedButtonId,
        public readonly string $selectedDisplayText,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            selectedButtonId: isset($data['selected_button_id']) ? (string) $data['selected_button_id'] : null,
            selectedDisplayText: isset($data['selected_display_text']) ? (string) $data['selected_display_text'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'reply_to' => $this->replyTo,
            'selected_button_id' => $this->selectedButtonId,
            'selected_display_text' => $this->selectedDisplayText,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
