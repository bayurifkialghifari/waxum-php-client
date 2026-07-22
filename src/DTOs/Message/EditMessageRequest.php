<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class EditMessageRequest
{
    public function __construct(
        public readonly string $messageId,
        public readonly string $text,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            text: isset($data['text']) ? (string) $data['text'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'message_id' => $this->messageId,
            'text' => $this->text,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
