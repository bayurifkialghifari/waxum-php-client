<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Fleet;

class ServerInfo
{
    public function __construct(
        public readonly ?string $version,
        public readonly LocationInfo $location,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            version: isset($data['version']) ? (string) $data['version'] : null,
            location: LocationInfo::fromArray((array) ($data['location'] ?? [])),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'version' => $this->version,
            'location' => $this->location->toArray(),
        ], fn ($val) => $val !== null);
    }
}
