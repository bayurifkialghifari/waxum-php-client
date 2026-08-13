<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

class WebhookDlqListResponse
{
    /**
     * @param  WebhookDlqEntry[]  $entries
     */
    public function __construct(
        public readonly int $count,
        public readonly array $entries,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            count: isset($data['count']) ? (int) $data['count'] : null,
            entries: array_map(
                fn (array $entry) => WebhookDlqEntry::fromArray($entry),
                (array) ($data['entries'] ?? []),
            ),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'count' => $this->count,
            'entries' => array_map(fn (WebhookDlqEntry $entry) => $entry->toArray(), $this->entries),
        ], fn ($val) => $val !== null);
    }
}
