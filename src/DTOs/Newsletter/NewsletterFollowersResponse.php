<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class NewsletterFollowersResponse
{
    public function __construct(
        public readonly string $followers,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            followers: isset($data['followers']) ? (string) $data['followers'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'followers' => $this->followers,
        ], fn ($val) => $val !== null);
    }
}
