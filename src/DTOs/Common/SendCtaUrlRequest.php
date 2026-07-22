<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendCtaUrlRequest
{
    public function __construct(
        public readonly ?string $bodyText,
        public readonly string $displayText,
        public readonly ?string $footerText,
        public readonly ?string $headerText,
        public readonly mixed $image = null,
        public readonly ?string $merchantUrl,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
        public readonly string $url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bodyText: isset($data['body_text']) ? (string) $data['body_text'] : null,
            displayText: isset($data['display_text']) ? (string) $data['display_text'] : null,
            footerText: isset($data['footer_text']) ? (string) $data['footer_text'] : null,
            headerText: isset($data['header_text']) ? (string) $data['header_text'] : null,
            image: $data['image'] ?? null,
            merchantUrl: isset($data['merchant_url']) ? (string) $data['merchant_url'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body_text' => $this->bodyText,
            'display_text' => $this->displayText,
            'footer_text' => $this->footerText,
            'header_text' => $this->headerText,
            'image' => $this->image,
            'merchant_url' => $this->merchantUrl,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
