<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class MarkAsReadRequest
{
    public function __construct(
        public readonly string $chatJid,
        public readonly array $messageIds,
        public readonly ?string $sender = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            chatJid: isset($data['chat_jid']) ? (string) $data['chat_jid'] : null,
            messageIds: (array) ($data['message_ids'] ?? []),
            sender: isset($data['sender']) ? (string) $data['sender'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'chat_jid' => $this->chatJid,
            'message_ids' => $this->messageIds,
            'sender' => $this->sender,
        ], fn ($val) => $val !== null);
    }
}
