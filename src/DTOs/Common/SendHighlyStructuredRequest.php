<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendHighlyStructuredRequest
{
    public function __construct(
        public readonly string $elementName,
        public readonly ?string $fallbackLc,
        public readonly ?string $fallbackLg,
        public readonly string $namespace,
        public readonly ?array $params,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            elementName: isset($data['element_name']) ? (string) $data['element_name'] : null,
            fallbackLc: isset($data['fallback_lc']) ? (string) $data['fallback_lc'] : null,
            fallbackLg: isset($data['fallback_lg']) ? (string) $data['fallback_lg'] : null,
            namespace: isset($data['namespace']) ? (string) $data['namespace'] : null,
            params: (array) ($data['params'] ?? []),
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'element_name' => $this->elementName,
            'fallback_lc' => $this->fallbackLc,
            'fallback_lg' => $this->fallbackLg,
            'namespace' => $this->namespace,
            'params' => $this->params,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
