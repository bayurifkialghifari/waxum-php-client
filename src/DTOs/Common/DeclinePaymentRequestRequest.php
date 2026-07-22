<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class DeclinePaymentRequestRequest
{
    public function __construct(
        public readonly string $requestMessageId,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            requestMessageId: isset($data['request_message_id']) ? (string) $data['request_message_id'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'request_message_id' => $this->requestMessageId,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
