<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class SendNewsletterForwardRequest
{
    public function __construct(
        public readonly ?string $contentType,
        public readonly string $newsletterJid,
        public readonly ?string $newsletterName,
        public readonly ?string $sendAt,
        public readonly int $serverMessageId,
        public readonly string $text,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            contentType: isset($data['content_type']) ? (string) $data['content_type'] : null,
            newsletterJid: isset($data['newsletter_jid']) ? (string) $data['newsletter_jid'] : null,
            newsletterName: isset($data['newsletter_name']) ? (string) $data['newsletter_name'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            serverMessageId: isset($data['server_message_id']) ? (int) $data['server_message_id'] : null,
            text: isset($data['text']) ? (string) $data['text'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'content_type' => $this->contentType,
            'newsletter_jid' => $this->newsletterJid,
            'newsletter_name' => $this->newsletterName,
            'send_at' => $this->sendAt,
            'server_message_id' => $this->serverMessageId,
            'text' => $this->text,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
