<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class PairCodeResponse
{
    public function __construct(
        public readonly string $code,
        public readonly int $timeoutSeconds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            timeoutSeconds: isset($data['timeout_seconds']) ? (int) $data['timeout_seconds'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'code' => $this->code,
            'timeout_seconds' => $this->timeoutSeconds,
        ], fn ($val) => $val !== null);
    }
}
