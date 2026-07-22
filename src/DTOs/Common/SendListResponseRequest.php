<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendListResponseRequest
{
    public function __construct(
        public readonly ?string $description,
        public readonly ?string $replyTo,
        public readonly string $selectedRowId,
        public readonly ?string $sendAt,
        public readonly string $title,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description: isset($data['description']) ? (string) $data['description'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            selectedRowId: isset($data['selected_row_id']) ? (string) $data['selected_row_id'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            title: isset($data['title']) ? (string) $data['title'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'description' => $this->description,
            'reply_to' => $this->replyTo,
            'selected_row_id' => $this->selectedRowId,
            'send_at' => $this->sendAt,
            'title' => $this->title,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
