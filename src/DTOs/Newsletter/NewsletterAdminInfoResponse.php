<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class NewsletterAdminInfoResponse
{
    public function __construct(
        public readonly string $adminInfo,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            adminInfo: isset($data['admin_info']) ? (string) $data['admin_info'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'admin_info' => $this->adminInfo,
        ], fn ($val) => $val !== null);
    }
}
