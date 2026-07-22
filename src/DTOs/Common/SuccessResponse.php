<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SuccessResponse
{
    public function __construct(
        public readonly ?string $message,
        public readonly bool $success,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            message: isset($data['message']) ? (string) $data['message'] : null,
            success: (bool) ($data['success'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'message' => $this->message,
            'success' => $this->success,
        ], fn ($val) => $val !== null);
    }
}
