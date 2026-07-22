<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Blast;

class BlastRecipient
{
    public function __construct(
        public readonly int $attempts,
        public readonly int $id,
        public readonly ?string $lastError,
        public readonly ?string $messageId,
        public readonly string $recipient,
        public readonly mixed $status,
        public readonly string $updatedAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            attempts: isset($data['attempts']) ? (int) $data['attempts'] : null,
            id: isset($data['id']) ? (int) $data['id'] : null,
            lastError: isset($data['last_error']) ? (string) $data['last_error'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            recipient: isset($data['recipient']) ? (string) $data['recipient'] : null,
            status: $data['status'] ?? null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'attempts' => $this->attempts,
            'id' => $this->id,
            'last_error' => $this->lastError,
            'message_id' => $this->messageId,
            'recipient' => $this->recipient,
            'status' => $this->status,
            'updated_at' => $this->updatedAt,
        ], fn ($val) => $val !== null);
    }
}
