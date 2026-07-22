<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\ChatState;

class SendTypingRequest
{
    public function __construct(
        public readonly string $to,
        public readonly ?int $duration = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: (string) ($data['to'] ?? ''),
            duration: isset($data['duration']) ? (int) $data['duration'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'to' => $this->to,
            'duration' => $this->duration,
        ], fn ($val) => $val !== null);
    }
}
