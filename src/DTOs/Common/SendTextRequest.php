<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendTextRequest
{
    public function __construct(
        public readonly mixed $fakeReply = null,
        public readonly ?bool $mentionAll,
        public readonly ?array $mentions,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $text,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            fakeReply: $data['fake_reply'] ?? null,
            mentionAll: isset($data['mention_all']) ? (bool) $data['mention_all'] : null,
            mentions: isset($data['mentions']) ? (array) $data['mentions'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            text: isset($data['text']) ? (string) $data['text'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'fake_reply' => $this->fakeReply,
            'mention_all' => $this->mentionAll,
            'mentions' => $this->mentions,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'text' => $this->text,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
