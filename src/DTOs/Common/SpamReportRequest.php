<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SpamReportRequest
{
    public function __construct(
        public readonly ?string $fromJid,
        public readonly ?string $groupJid,
        public readonly ?string $groupSubject,
        public readonly ?string $mediaType,
        public readonly string $messageId,
        public readonly int $messageTimestamp,
        public readonly ?string $participantJid = null,
        public readonly ?string $spamFlow = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            fromJid: isset($data['from_jid']) ? (string) $data['from_jid'] : null,
            groupJid: isset($data['group_jid']) ? (string) $data['group_jid'] : null,
            groupSubject: isset($data['group_subject']) ? (string) $data['group_subject'] : null,
            mediaType: isset($data['media_type']) ? (string) $data['media_type'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            messageTimestamp: isset($data['message_timestamp']) ? (int) $data['message_timestamp'] : null,
            participantJid: isset($data['participant_jid']) ? (string) $data['participant_jid'] : null,
            spamFlow: isset($data['spam_flow']) ? (string) $data['spam_flow'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'from_jid' => $this->fromJid,
            'group_jid' => $this->groupJid,
            'group_subject' => $this->groupSubject,
            'media_type' => $this->mediaType,
            'message_id' => $this->messageId,
            'message_timestamp' => $this->messageTimestamp,
            'participant_jid' => $this->participantJid,
            'spam_flow' => $this->spamFlow,
        ], fn ($val) => $val !== null);
    }
}
