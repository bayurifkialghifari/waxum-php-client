<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Message;

class ScheduledMessage
{
    public function __construct(
        public readonly string $createdAt,
        public readonly string $endpoint,
        public readonly ?string $error,
        public readonly string $id,
        public readonly ?string $messageId,
        public readonly string $sendAt,
        public readonly string $sessionId,
        public readonly mixed $status,
        public readonly string $updatedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            endpoint: isset($data['endpoint']) ? (string) $data['endpoint'] : null,
            error: isset($data['error']) ? (string) $data['error'] : null,
            id: isset($data['id']) ? (string) $data['id'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            sessionId: isset($data['session_id']) ? (string) $data['session_id'] : null,
            status: $data['status'] ?? null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'created_at' => $this->createdAt,
            'endpoint' => $this->endpoint,
            'error' => $this->error,
            'id' => $this->id,
            'message_id' => $this->messageId,
            'send_at' => $this->sendAt,
            'session_id' => $this->sessionId,
            'status' => $this->status,
            'updated_at' => $this->updatedAt,
        ], fn ($val) => $val !== null);
    }
}
