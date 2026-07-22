<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\ChatState;

class SendChatStateRequest
{
    public function __construct(
        public readonly mixed $state,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            state: $data['state'] ?? null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'state' => $this->state,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
