<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendPaymentRequest
{
    public function __construct(
        public readonly ?string $note,
        public readonly ?string $requestMessageId,
        public readonly ?string $sendAt,
        public readonly string $to,
        public readonly ?string $transactionData = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            note: isset($data['note']) ? (string) $data['note'] : null,
            requestMessageId: isset($data['request_message_id']) ? (string) $data['request_message_id'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            transactionData: isset($data['transaction_data']) ? (string) $data['transaction_data'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'note' => $this->note,
            'request_message_id' => $this->requestMessageId,
            'send_at' => $this->sendAt,
            'to' => $this->to,
            'transaction_data' => $this->transactionData,
        ], fn ($val) => $val !== null);
    }
}
