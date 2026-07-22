<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Mex;

class MexGraphQLErrorItem
{
    public function __construct(
        public readonly ?int $errorCode,
        public readonly ?bool $isRetryable,
        public readonly string $message,
        public readonly ?string $severity = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            errorCode: isset($data['error_code']) ? (int) $data['error_code'] : null,
            isRetryable: (bool) ($data['is_retryable'] ?? false),
            message: isset($data['message']) ? (string) $data['message'] : null,
            severity: isset($data['severity']) ? (string) $data['severity'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'error_code' => $this->errorCode,
            'is_retryable' => $this->isRetryable,
            'message' => $this->message,
            'severity' => $this->severity,
        ], fn ($val) => $val !== null);
    }
}
