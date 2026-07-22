<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class TtsCallResponse
{
    public function __construct(
        public readonly string $callId,
        public readonly ?string $recordingUrl,
        public readonly string $to,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            callId: isset($data['call_id']) ? (string) $data['call_id'] : null,
            recordingUrl: isset($data['recording_url']) ? (string) $data['recording_url'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'call_id' => $this->callId,
            'recording_url' => $this->recordingUrl,
            'to' => $this->to,
        ], fn ($val) => $val !== null);
    }
}
