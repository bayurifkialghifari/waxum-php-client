<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendTemplateButtonReplyRequest
{
    public function __construct(
        public readonly ?string $replyTo,
        public readonly string $selectedDisplayText,
        public readonly string $selectedId,
        public readonly ?int $selectedIndex,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            selectedDisplayText: isset($data['selected_display_text']) ? (string) $data['selected_display_text'] : null,
            selectedId: isset($data['selected_id']) ? (string) $data['selected_id'] : null,
            selectedIndex: isset($data['selected_index']) ? (int) $data['selected_index'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'reply_to' => $this->replyTo,
            'selected_display_text' => $this->selectedDisplayText,
            'selected_id' => $this->selectedId,
            'selected_index' => $this->selectedIndex,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
