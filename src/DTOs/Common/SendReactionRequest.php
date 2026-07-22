<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendReactionRequest
{
    public function __construct(
        public readonly string $emoji,
        public readonly string $messageId,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            emoji: isset($data['emoji']) ? (string) $data['emoji'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'emoji' => $this->emoji,
            'message_id' => $this->messageId,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
