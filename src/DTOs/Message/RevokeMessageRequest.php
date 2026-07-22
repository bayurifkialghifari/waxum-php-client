<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class RevokeMessageRequest
{
    public function __construct(
        public readonly string $messageId,
        public readonly ?string $originalSender,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            originalSender: isset($data['original_sender']) ? (string) $data['original_sender'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'message_id' => $this->messageId,
            'original_sender' => $this->originalSender,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
