<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendResult
{
    public function __construct(
        public readonly ?string $error,
        public readonly ?string $messageId,
        public readonly ?string $requestId,
        public readonly bool $success,
        public readonly int $timestamp,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            error: isset($data['error']) ? (string) $data['error'] : null,
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            requestId: isset($data['request_id']) ? (string) $data['request_id'] : null,
            success: (bool) ($data['success'] ?? false),
            timestamp: isset($data['timestamp']) ? (int) $data['timestamp'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'error' => $this->error,
            'message_id' => $this->messageId,
            'request_id' => $this->requestId,
            'success' => $this->success,
            'timestamp' => $this->timestamp,
        ], fn ($val) => $val !== null);
    }
}
