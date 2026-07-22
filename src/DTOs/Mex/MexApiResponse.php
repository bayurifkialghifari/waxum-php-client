<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Mex;

class MexApiResponse
{
    public function __construct(
        public readonly mixed $data = null,
        public readonly ?array $errors = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            data: $data['data'] ?? null,
            errors: (array) ($data['errors'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'data' => $this->data,
            'errors' => $this->errors,
        ], fn ($val) => $val !== null);
    }
}
