<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendListRequest
{
    public function __construct(
        public readonly string $buttonText,
        public readonly string $description,
        public readonly ?string $footer,
        public readonly ?string $replyTo,
        public readonly array $sections,
        public readonly ?string $sendAt,
        public readonly string $title,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            buttonText: isset($data['button_text']) ? (string) $data['button_text'] : null,
            description: isset($data['description']) ? (string) $data['description'] : null,
            footer: isset($data['footer']) ? (string) $data['footer'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sections: (array) ($data['sections'] ?? []),
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            title: isset($data['title']) ? (string) $data['title'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'button_text' => $this->buttonText,
            'description' => $this->description,
            'footer' => $this->footer,
            'reply_to' => $this->replyTo,
            'sections' => $this->sections,
            'send_at' => $this->sendAt,
            'title' => $this->title,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
