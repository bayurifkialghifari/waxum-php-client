<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class MessageResponse
{
    public function __construct(
        public readonly string $messageId,
        public readonly int $timestamp,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            timestamp: isset($data['timestamp']) ? (int) $data['timestamp'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'message_id' => $this->messageId,
            'timestamp' => $this->timestamp,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
