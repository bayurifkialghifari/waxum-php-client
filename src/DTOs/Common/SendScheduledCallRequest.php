<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendScheduledCallRequest
{
    public function __construct(
        public readonly ?string $callType,
        public readonly int $scheduledTimestampMs,
        public readonly ?string $sendAt,
        public readonly ?string $title,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            callType: isset($data['call_type']) ? (string) $data['call_type'] : null,
            scheduledTimestampMs: isset($data['scheduled_timestamp_ms']) ? (int) $data['scheduled_timestamp_ms'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            title: isset($data['title']) ? (string) $data['title'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'call_type' => $this->callType,
            'scheduled_timestamp_ms' => $this->scheduledTimestampMs,
            'send_at' => $this->sendAt,
            'title' => $this->title,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
