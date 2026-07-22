<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TerminateCallRequest
{
    public function __construct(
        public readonly string $callId,
        public readonly string $peer,
        public readonly ?string $reason = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            callId: isset($data['call_id']) ? (string) $data['call_id'] : null,
            peer: isset($data['peer']) ? (string) $data['peer'] : null,
            reason: isset($data['reason']) ? (string) $data['reason'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'call_id' => $this->callId,
            'peer' => $this->peer,
            'reason' => $this->reason,
        ], fn ($val) => $val !== null);
    }
}
