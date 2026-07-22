<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class DevicePropsRequest
{
    public function __construct(
        public readonly ?string $os = null,
        public readonly ?string $platform = null,
        public readonly ?string $version = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            os: isset($data['os']) ? (string) $data['os'] : null,
            platform: isset($data['platform']) ? (string) $data['platform'] : null,
            version: isset($data['version']) ? (string) $data['version'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'os' => $this->os,
            'platform' => $this->platform,
            'version' => $this->version,
        ], fn ($val) => $val !== null);
    }
}
