<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class CreateSessionResponse
{
    public function __construct(
        public readonly ?SessionInfo $session,
    ) {}

    public static function fromArray(array $data): self
    {
        $sessionData = $data['session'] ?? null;

        return new self(
            session: is_array($sessionData)
                ? SessionInfo::fromArray($sessionData)
                : ($sessionData instanceof SessionInfo ? $sessionData : null),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'session' => $this->session?->toArray(),
        ], fn ($val) => $val !== null);
    }
}
