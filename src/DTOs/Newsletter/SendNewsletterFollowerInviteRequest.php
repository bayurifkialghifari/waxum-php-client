<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class SendNewsletterFollowerInviteRequest
{
    public function __construct(
        public readonly ?string $caption,
        public readonly string $newsletterJid,
        public readonly string $newsletterName,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            caption: isset($data['caption']) ? (string) $data['caption'] : null,
            newsletterJid: isset($data['newsletter_jid']) ? (string) $data['newsletter_jid'] : null,
            newsletterName: isset($data['newsletter_name']) ? (string) $data['newsletter_name'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'caption' => $this->caption,
            'newsletter_jid' => $this->newsletterJid,
            'newsletter_name' => $this->newsletterName,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
