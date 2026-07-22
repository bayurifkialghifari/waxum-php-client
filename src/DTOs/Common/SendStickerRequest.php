<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendStickerRequest
{
    public function __construct(
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly mixed $sticker,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            sticker: $data['sticker'] ?? null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'sticker' => $this->sticker,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
