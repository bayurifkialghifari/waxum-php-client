<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Newsletter;

class SendNewsletterAdminInviteRequest
{
    public function __construct(
        public readonly ?string $caption,
        public readonly ?int $inviteExpiration,
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
            inviteExpiration: isset($data['invite_expiration']) ? (int) $data['invite_expiration'] : null,
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
            'invite_expiration' => $this->inviteExpiration,
            'newsletter_jid' => $this->newsletterJid,
            'newsletter_name' => $this->newsletterName,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
