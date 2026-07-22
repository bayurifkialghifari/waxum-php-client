<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class DeviceInfo
{
    public function __construct(
        public readonly ?int $deviceId = null,
        public readonly ?string $lid = null,
        public readonly ?string $phoneNumber = null,
        public readonly ?string $pushName = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            deviceId: isset($data['device_id']) ? (int) $data['device_id'] : null,
            lid: isset($data['lid']) ? (string) $data['lid'] : null,
            phoneNumber: isset($data['phone_number']) ? (string) $data['phone_number'] : null,
            pushName: isset($data['push_name']) ? (string) $data['push_name'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'device_id' => $this->deviceId,
            'lid' => $this->lid,
            'phone_number' => $this->phoneNumber,
            'push_name' => $this->pushName,
        ], fn ($val) => $val !== null);
    }
}
