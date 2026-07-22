<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendVideoRequest
{
    public function __construct(
        public readonly ?string $caption,
        public readonly mixed $fakeReply = null,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
        public readonly mixed $video,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            caption: isset($data['caption']) ? (string) $data['caption'] : null,
            fakeReply: $data['fake_reply'] ?? null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            video: $data['video'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'caption' => $this->caption,
            'fake_reply' => $this->fakeReply,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
            'video' => $this->video,
        ], fn ($val) => $val !== null);
    }
}
