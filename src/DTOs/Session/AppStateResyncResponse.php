<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class AppStateResyncResponse
{
    /**
     * @param  string[]  $synced
     * @param  string[]  $fatal
     * @param  string[]  $retryable
     * @param  string[]  $skipped
     */
    public function __construct(
        public readonly bool $allSynced,
        public readonly array $fatal,
        public readonly array $retryable,
        public readonly array $skipped,
        public readonly array $synced,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            allSynced: (bool) ($data['all_synced'] ?? false),
            fatal: array_map('strval', (array) ($data['fatal'] ?? [])),
            retryable: array_map('strval', (array) ($data['retryable'] ?? [])),
            skipped: array_map('strval', (array) ($data['skipped'] ?? [])),
            synced: array_map('strval', (array) ($data['synced'] ?? [])),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'all_synced' => $this->allSynced,
            'fatal' => $this->fatal,
            'retryable' => $this->retryable,
            'skipped' => $this->skipped,
            'synced' => $this->synced,
        ], fn ($val) => $val !== null);
    }
}
