<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendLocationRequest
{
    public function __construct(
        public readonly ?string $address,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ?string $name,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            address: isset($data['address']) ? (string) $data['address'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'name' => $this->name,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
