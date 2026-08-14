<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class SearchResponse
{
    /**
     * @param  SearchHit[]  $hits
     */
    public function __construct(
        public readonly string $q,
        public readonly int $total,
        public readonly array $hits,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            q: (string) ($data['q'] ?? ''),
            total: (int) ($data['total'] ?? 0),
            hits: array_map(
                fn (array $hit) => SearchHit::fromArray($hit),
                (array) ($data['hits'] ?? []),
            ),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'q' => $this->q,
            'total' => $this->total,
            'hits' => array_map(fn (SearchHit $hit) => $hit->toArray(), $this->hits),
        ], fn ($val) => $val !== null);
    }
}
