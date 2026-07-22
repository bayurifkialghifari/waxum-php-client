<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class UserInfoResponse
{
    public function __construct(
        public readonly array $users,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            users: (array) ($data['users'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'users' => $this->users,
        ], fn ($val) => $val !== null);
    }
}
