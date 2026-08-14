<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class DisconnectAllResponse
{
    /**
     * @param  string[]  $disconnected
     * @param  string[]  $skipped
     */
    public function __construct(
        public readonly array $disconnected,
        public readonly array $skipped,
        public readonly int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            disconnected: array_map('strval', (array) ($data['disconnected'] ?? [])),
            skipped: array_map('strval', (array) ($data['skipped'] ?? [])),
            total: (int) ($data['total'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'disconnected' => $this->disconnected,
            'skipped' => $this->skipped,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
