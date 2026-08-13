<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Business;

class BusinessOrderResponse
{
    public function __construct(
        public readonly string $order,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            order: isset($data['order']) ? (string) $data['order'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'order' => $this->order,
        ], fn ($val) => $val !== null);
    }
}
