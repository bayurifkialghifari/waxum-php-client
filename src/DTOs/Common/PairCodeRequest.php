<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class PairCodeRequest
{
    public function __construct(
        public readonly mixed $device = null,
        public readonly string $phoneNumber,
        public readonly ?bool $showPushNotification = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            device: $data['device'] ?? null,
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            showPushNotification: (bool) ($data['show_push_notification'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'device' => $this->device,
            'phone_number' => $this->phoneNumber,
            'show_push_notification' => $this->showPushNotification,
        ], fn ($val) => $val !== null);
    }
}
