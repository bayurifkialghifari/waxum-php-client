<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class NativeFlowButtonItem
{
    public function __construct(
        public readonly string $buttonParamsJson,
        public readonly string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            buttonParamsJson: isset($data['button_params_json']) ? (string) $data['button_params_json'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'button_params_json' => $this->buttonParamsJson,
            'name' => $this->name,
        ], fn ($val) => $val !== null);
    }
}
