<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendCommentRequest
{
    public function __construct(
        public readonly ?string $sendAt,
        public readonly ?string $targetChatJid,
        public readonly string $targetMessageId,
        public readonly ?string $targetParticipant,
        public readonly string $text,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            targetChatJid: isset($data['target_chat_jid']) ? (string) $data['target_chat_jid'] : null,
            targetMessageId: isset($data['target_message_id']) ? (string) $data['target_message_id'] : null,
            targetParticipant: isset($data['target_participant']) ? (string) $data['target_participant'] : null,
            text: isset($data['text']) ? (string) $data['text'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'send_at' => $this->sendAt,
            'target_chat_jid' => $this->targetChatJid,
            'target_message_id' => $this->targetMessageId,
            'target_participant' => $this->targetParticipant,
            'text' => $this->text,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
