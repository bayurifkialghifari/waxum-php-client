<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Token;

class TokenListResponse
{
    /**
     * @param  TokenSummary[]  $tokens
     */
    public function __construct(
        public readonly array $tokens,
        public readonly int $count,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tokens: array_map(
                fn (array $token) => TokenSummary::fromArray($token),
                (array) ($data['tokens'] ?? []),
            ),
            count: (int) ($data['count'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'tokens' => array_map(fn (TokenSummary $token) => $token->toArray(), $this->tokens),
            'count' => $this->count,
        ], fn ($val) => $val !== null);
    }
}
