<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendButtonsRequest
{
    public function __construct(
        public readonly array $buttons,
        public readonly string $contentText,
        public readonly ?string $footer,
        public readonly ?string $headerText,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            buttons: (array) ($data['buttons'] ?? []),
            contentText: isset($data['content_text']) ? (string) $data['content_text'] : null,
            footer: isset($data['footer']) ? (string) $data['footer'] : null,
            headerText: isset($data['header_text']) ? (string) $data['header_text'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'buttons' => $this->buttons,
            'content_text' => $this->contentText,
            'footer' => $this->footer,
            'header_text' => $this->headerText,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
