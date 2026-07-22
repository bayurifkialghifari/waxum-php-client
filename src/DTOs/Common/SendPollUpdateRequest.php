<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendPollUpdateRequest
{
    public function __construct(
        public readonly ?string $encIv,
        public readonly ?string $encPayload,
        public readonly string $pollMessageId,
        public readonly array $selectedOptions,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            encIv: isset($data['enc_iv']) ? (string) $data['enc_iv'] : null,
            encPayload: isset($data['enc_payload']) ? (string) $data['enc_payload'] : null,
            pollMessageId: isset($data['poll_message_id']) ? (string) $data['poll_message_id'] : null,
            selectedOptions: (array) ($data['selected_options'] ?? []),
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'enc_iv' => $this->encIv,
            'enc_payload' => $this->encPayload,
            'poll_message_id' => $this->pollMessageId,
            'selected_options' => $this->selectedOptions,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
