<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class NewsletterMuteResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly ?bool $muted,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            success: (bool) ($data['success'] ?? false),
            muted: isset($data['muted']) ? (bool) $data['muted'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'success' => $this->success,
            'muted' => $this->muted,
        ], fn ($val) => $val !== null);
    }
}
