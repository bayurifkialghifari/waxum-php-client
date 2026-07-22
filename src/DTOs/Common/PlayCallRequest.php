<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class PlayCallRequest
{
    public function __construct(
        public readonly ?int $answerGraceMs,
        public readonly string $audioUrl,
        public readonly ?bool $record,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            answerGraceMs: isset($data['answer_grace_ms']) ? (int) $data['answer_grace_ms'] : null,
            audioUrl: isset($data['audio_url']) ? (string) $data['audio_url'] : null,
            record: (bool) ($data['record'] ?? false),
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'answer_grace_ms' => $this->answerGraceMs,
            'audio_url' => $this->audioUrl,
            'record' => $this->record,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
