<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Privacy;

class PrivacySettingsResponse
{
    public function __construct(
        public readonly array $settings,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            settings: (array) ($data['settings'] ?? []),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'settings' => $this->settings,
        ], fn ($val) => $val !== null);
    }
}
