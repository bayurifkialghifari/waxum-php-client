<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendQuickReplyRequest
{
    public function __construct(
        public readonly string $bodyText,
        public readonly array $buttons,
        public readonly ?string $footerText,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bodyText: isset($data['body_text']) ? (string) $data['body_text'] : null,
            buttons: (array) ($data['buttons'] ?? []),
            footerText: isset($data['footer_text']) ? (string) $data['footer_text'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body_text' => $this->bodyText,
            'buttons' => $this->buttons,
            'footer_text' => $this->footerText,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
