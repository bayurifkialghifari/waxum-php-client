<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendDocumentRequest
{
    public function __construct(
        public readonly ?string $caption,
        public readonly mixed $document,
        public readonly mixed $fakeReply = null,
        public readonly string $filename,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            caption: isset($data['caption']) ? (string) $data['caption'] : null,
            document: $data['document'] ?? null,
            fakeReply: $data['fake_reply'] ?? null,
            filename: isset($data['filename']) ? (string) $data['filename'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'caption' => $this->caption,
            'document' => $this->document,
            'fake_reply' => $this->fakeReply,
            'filename' => $this->filename,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
