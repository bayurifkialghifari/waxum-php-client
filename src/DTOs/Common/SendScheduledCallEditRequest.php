<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendScheduledCallEditRequest
{
    public function __construct(
        public readonly ?string $editType,
        public readonly string $scheduledCallMessageId,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            editType: isset($data['edit_type']) ? (string) $data['edit_type'] : null,
            scheduledCallMessageId: isset($data['scheduled_call_message_id']) ? (string) $data['scheduled_call_message_id'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'edit_type' => $this->editType,
            'scheduled_call_message_id' => $this->scheduledCallMessageId,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
