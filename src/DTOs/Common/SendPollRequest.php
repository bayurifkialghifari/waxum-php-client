<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendPollRequest
{
    public function __construct(
        public readonly string $name,
        public readonly array $options,
        public readonly ?string $replyTo,
        public readonly ?int $selectableCount,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? (string) $data['name'] : null,
            options: (array) ($data['options'] ?? []),
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            selectableCount: isset($data['selectable_count']) ? (int) $data['selectable_count'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'options' => $this->options,
            'reply_to' => $this->replyTo,
            'selectable_count' => $this->selectableCount,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
