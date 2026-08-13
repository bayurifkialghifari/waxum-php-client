<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class PauseStateResponse
{
    public function __construct(
        public readonly bool $paused,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            paused: (bool) ($data['paused'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'paused' => $this->paused,
        ], fn ($val) => $val !== null);
    }
}
