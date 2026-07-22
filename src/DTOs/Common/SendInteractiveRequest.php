<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendInteractiveRequest
{
    public function __construct(
        public readonly string $bodyText,
        public readonly array $buttons,
        public readonly mixed $fakeReply = null,
        public readonly ?string $footerText,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
        public readonly ?bool $viewOnce = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bodyText: isset($data['body_text']) ? (string) $data['body_text'] : null,
            buttons: (array) ($data['buttons'] ?? []),
            fakeReply: $data['fake_reply'] ?? null,
            footerText: isset($data['footer_text']) ? (string) $data['footer_text'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            viewOnce: (bool) ($data['view_once'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body_text' => $this->bodyText,
            'buttons' => $this->buttons,
            'fake_reply' => $this->fakeReply,
            'footer_text' => $this->footerText,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
            'view_once' => $this->viewOnce,
        ], fn ($val) => $val !== null);
    }
}
