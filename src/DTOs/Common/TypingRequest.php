<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TypingRequest
{
    public function __construct(
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
