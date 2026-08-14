<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Bots;

class BotListResponse
{
    public function __construct(
        public readonly string $bots,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bots: isset($data['bots']) ? (string) $data['bots'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'bots' => $this->bots,
        ], fn ($val) => $val !== null);
    }
}
