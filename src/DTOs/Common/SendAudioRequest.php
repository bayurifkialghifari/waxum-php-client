<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendAudioRequest
{
    public function __construct(
        public readonly mixed $audio,
        public readonly ?bool $ptt,
        public readonly ?string $replyTo,
        public readonly ?string $sendAt,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            audio: $data['audio'] ?? null,
            ptt: (bool) ($data['ptt'] ?? false),
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'audio' => $this->audio,
            'ptt' => $this->ptt,
            'reply_to' => $this->replyTo,
            'send_at' => $this->sendAt,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
