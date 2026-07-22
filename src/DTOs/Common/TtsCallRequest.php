<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TtsCallRequest
{
    public function __construct(
        public readonly ?int $answerGraceMs,
        public readonly ?bool $record,
        public readonly string $text,
        public readonly string $to,
        public readonly ?string $voice = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            answerGraceMs: isset($data['answer_grace_ms']) ? (int) $data['answer_grace_ms'] : null,
            record: (bool) ($data['record'] ?? false),
            text: isset($data['text']) ? (string) $data['text'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            voice: isset($data['voice']) ? (string) $data['voice'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'answer_grace_ms' => $this->answerGraceMs,
            'record' => $this->record,
            'text' => $this->text,
            'to' => $this->to,
            'voice' => $this->voice,
        ], fn ($val) => $val !== null);
    }
}
