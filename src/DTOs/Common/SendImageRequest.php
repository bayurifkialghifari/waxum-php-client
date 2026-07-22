<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendImageRequest
{
    public function __construct(
        public readonly ?string $caption,
        public readonly mixed $fakeReply = null,
        public readonly mixed $image,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            caption: isset($data['caption']) ? (string) $data['caption'] : null,
            fakeReply: $data['fake_reply'] ?? null,
            image: $data['image'] ?? null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'caption' => $this->caption,
            'fake_reply' => $this->fakeReply,
            'image' => $this->image,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
