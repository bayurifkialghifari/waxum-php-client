<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendResponse
{
    public function __construct(
        public readonly ?string $messageId,
        public readonly ?string $scheduleId,
        public readonly ?string $sendAt,
        public readonly string $status,
        public readonly ?int $timestamp = null,
        public readonly ?string $to = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            scheduleId: isset($data['schedule_id']) ? (string) $data['schedule_id'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
            timestamp: isset($data['timestamp']) ? (int) $data['timestamp'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'message_id' => $this->messageId,
            'schedule_id' => $this->scheduleId,
            'send_at' => $this->sendAt,
            'status' => $this->status,
            'timestamp' => $this->timestamp,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
