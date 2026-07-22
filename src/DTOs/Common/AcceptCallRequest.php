<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class AcceptCallRequest
{
    public function __construct(
        public readonly ?int $answerGraceMs,
        public readonly ?string $audioUrl,
        public readonly string $callId,
        public readonly string $from,
        public readonly ?string $text = null,
        public readonly ?string $voice = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            answerGraceMs: isset($data['answer_grace_ms']) ? (int) $data['answer_grace_ms'] : null,
            audioUrl: isset($data['audio_url']) ? (string) $data['audio_url'] : null,
            callId: isset($data['call_id']) ? (string) $data['call_id'] : null,
            from: isset($data['from']) ? (string) $data['from'] : null,
            text: isset($data['text']) ? (string) $data['text'] : null,
            voice: isset($data['voice']) ? (string) $data['voice'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'answer_grace_ms' => $this->answerGraceMs,
            'audio_url' => $this->audioUrl,
            'call_id' => $this->callId,
            'from' => $this->from,
            'text' => $this->text,
            'voice' => $this->voice,
        ], fn ($val) => $val !== null);
    }
}
