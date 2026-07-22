<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendInteractiveResponseRequest
{
    public function __construct(
        public readonly ?string $bodyText,
        public readonly string $name,
        public readonly string $paramsJson,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
        public readonly ?int $version = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bodyText: isset($data['body_text']) ? (string) $data['body_text'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            paramsJson: isset($data['params_json']) ? (string) $data['params_json'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            version: isset($data['version']) ? (int) $data['version'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'body_text' => $this->bodyText,
            'name' => $this->name,
            'params_json' => $this->paramsJson,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
            'version' => $this->version,
        ], fn ($val) => $val !== null);
    }
}
