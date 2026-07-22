<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class HistorySyncResponse
{
    public function __construct(
        public readonly bool $skipHistorySync,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            skipHistorySync: (bool) ($data['skip_history_sync'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'skip_history_sync' => $this->skipHistorySync,
        ], fn ($val) => $val !== null);
    }
}
