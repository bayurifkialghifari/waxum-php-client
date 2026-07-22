<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class RejectCallRequest
{
    public function __construct(
        public readonly string $callId,
        public readonly string $from,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            callId: isset($data['call_id']) ? (string) $data['call_id'] : null,
            from: isset($data['from']) ? (string) $data['from'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'call_id' => $this->callId,
            'from' => $this->from,
        ], fn ($val) => $val !== null);
    }
}
