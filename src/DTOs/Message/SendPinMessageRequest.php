<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class SendPinMessageRequest
{
    public function __construct(
        public readonly string $chat,
        public readonly ?int $durationSeconds,
        public readonly string $messageId,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            chat: isset($data['chat']) ? (string) $data['chat'] : null,
            durationSeconds: isset($data['duration_seconds']) ? (int) $data['duration_seconds'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'chat' => $this->chat,
            'duration_seconds' => $this->durationSeconds,
            'message_id' => $this->messageId,
        ], fn ($val) => $val !== null);
    }
}
