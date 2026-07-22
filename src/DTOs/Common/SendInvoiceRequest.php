<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendInvoiceRequest
{
    public function __construct(
        public readonly ?string $attachmentMimetype,
        public readonly ?string $attachmentType,
        public readonly ?string $note,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
        public readonly ?string $token = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            attachmentMimetype: isset($data['attachment_mimetype']) ? (string) $data['attachment_mimetype'] : null,
            attachmentType: isset($data['attachment_type']) ? (string) $data['attachment_type'] : null,
            note: isset($data['note']) ? (string) $data['note'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            token: isset($data['token']) ? (string) $data['token'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'attachment_mimetype' => $this->attachmentMimetype,
            'attachment_type' => $this->attachmentType,
            'note' => $this->note,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
            'token' => $this->token,
        ], fn ($val) => $val !== null);
    }
}
