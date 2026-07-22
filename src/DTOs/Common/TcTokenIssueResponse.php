<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TcTokenIssueResponse
{
    public function __construct(
        public readonly array $tokens,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tokens: (array) ($data['tokens'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'tokens' => $this->tokens,
        ], fn ($val) => $val !== null);
    }
}
