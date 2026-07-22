<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class MessageHit
{
    public function __construct(
        public readonly ?string $body,
        public readonly string $chatJid,
        public readonly string $direction,
        public readonly int $id,
        public readonly string $messageId,
        public readonly string $msgTimestamp,
        public readonly string $msgType,
        public readonly string $senderJid,
        public readonly string $sessionId,
        public readonly ?string $snippet = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            body: isset($data['body']) ? (string) $data['body'] : null,
            chatJid: isset($data['chat_jid']) ? (string) $data['chat_jid'] : null,
            direction: isset($data['direction']) ? (string) $data['direction'] : null,
            id: isset($data['id']) ? (int) $data['id'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            msgTimestamp: isset($data['msg_timestamp']) ? (string) $data['msg_timestamp'] : null,
            msgType: isset($data['msg_type']) ? (string) $data['msg_type'] : null,
            senderJid: isset($data['sender_jid']) ? (string) $data['sender_jid'] : null,
            sessionId: isset($data['session_id']) ? (string) $data['session_id'] : null,
            snippet: isset($data['snippet']) ? (string) $data['snippet'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body' => $this->body,
            'chat_jid' => $this->chatJid,
            'direction' => $this->direction,
            'id' => $this->id,
            'message_id' => $this->messageId,
            'msg_timestamp' => $this->msgTimestamp,
            'msg_type' => $this->msgType,
            'sender_jid' => $this->senderJid,
            'session_id' => $this->sessionId,
            'snippet' => $this->snippet,
        ], fn ($val) => $val !== null);
    }
}
