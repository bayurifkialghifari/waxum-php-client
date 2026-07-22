<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class CreateSessionResponse
{
    public function __construct(
        public readonly mixed $session,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            session: $data['session'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'session' => $this->session,
        ], fn ($val) => $val !== null);
    }
}
