<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Fleet;

class LocationInfo
{
    public function __construct(
        public readonly ?string $ip,
        public readonly ?string $countryCode,
        public readonly ?string $countryName,
        public readonly ?string $city,
        public readonly ?string $region,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?string $timezone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            ip: isset($data['ip']) ? (string) $data['ip'] : null,
            countryCode: isset($data['country_code']) ? (string) $data['country_code'] : null,
            countryName: isset($data['country_name']) ? (string) $data['country_name'] : null,
            city: isset($data['city']) ? (string) $data['city'] : null,
            region: isset($data['region']) ? (string) $data['region'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            timezone: isset($data['timezone']) ? (string) $data['timezone'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'ip' => $this->ip,
            'country_code' => $this->countryCode,
            'country_name' => $this->countryName,
            'city' => $this->city,
            'region' => $this->region,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'timezone' => $this->timezone,
        ], fn ($val) => $val !== null);
    }
}
