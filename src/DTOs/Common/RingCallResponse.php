<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class RingCallResponse
{
    public function __construct(
        public readonly string $callId,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            callId: isset($data['call_id']) ? (string) $data['call_id'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'call_id' => $this->callId,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
