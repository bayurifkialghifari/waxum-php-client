<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Labels;

class MessageLabelRequest
{
    public function __construct(
        public readonly string $chatJid,
        public readonly string $messageId,
        public readonly bool $fromMe,
        public readonly ?string $participant = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            chatJid: isset($data['chat_jid']) ? (string) $data['chat_jid'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            fromMe: isset($data['from_me']) ? (bool) $data['from_me'] : null,
            participant: isset($data['participant']) ? (string) $data['participant'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'chat_jid' => $this->chatJid,
            'message_id' => $this->messageId,
            'from_me' => $this->fromMe,
            'participant' => $this->participant,
        ], fn ($val) => $val !== null);
    }
}
