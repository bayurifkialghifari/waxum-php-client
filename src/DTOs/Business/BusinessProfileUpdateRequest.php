<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Business;

class BusinessProfileUpdateRequest
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $email = null,
        public readonly ?array $websites = null,
        public readonly ?string $address = null,
        public readonly ?string $category = null,
        public readonly ?array $businessHours = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description: isset($data['description']) ? (string) $data['description'] : null,
            email: isset($data['email']) ? (string) $data['email'] : null,
            websites: isset($data['websites']) ? (array) $data['websites'] : null,
            address: isset($data['address']) ? (string) $data['address'] : null,
            category: isset($data['category']) ? (string) $data['category'] : null,
            businessHours: isset($data['business_hours']) ? (array) $data['business_hours'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'description' => $this->description,
            'email' => $this->email,
            'websites' => $this->websites,
            'address' => $this->address,
            'category' => $this->category,
            'business_hours' => $this->businessHours,
        ], fn ($val) => $val !== null);
    }
}
