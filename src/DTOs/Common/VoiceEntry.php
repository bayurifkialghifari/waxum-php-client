<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class VoiceEntry
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $shortName,
        public readonly ?string $locale,
        public readonly ?string $gender,
        public readonly ?string $friendlyName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? (string) $data['name'] : null,
            shortName: isset($data['short_name']) ? (string) $data['short_name'] : null,
            locale: isset($data['locale']) ? (string) $data['locale'] : null,
            gender: isset($data['gender']) ? (string) $data['gender'] : null,
            friendlyName: isset($data['friendly_name']) ? (string) $data['friendly_name'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'short_name' => $this->shortName,
            'locale' => $this->locale,
            'gender' => $this->gender,
            'friendly_name' => $this->friendlyName,
        ], fn ($val) => $val !== null);
    }
}
