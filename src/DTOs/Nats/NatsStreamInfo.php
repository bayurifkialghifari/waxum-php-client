<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Nats;

class NatsStreamInfo
{
    public function __construct(
        public readonly int $bytes,
        public readonly int $consumerCount,
        public readonly int $firstSeq,
        public readonly int $lastSeq,
        public readonly int $messages,
        public readonly string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bytes: isset($data['bytes']) ? (int) $data['bytes'] : null,
            consumerCount: isset($data['consumer_count']) ? (int) $data['consumer_count'] : null,
            firstSeq: isset($data['first_seq']) ? (int) $data['first_seq'] : null,
            lastSeq: isset($data['last_seq']) ? (int) $data['last_seq'] : null,
            messages: isset($data['messages']) ? (int) $data['messages'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'bytes' => $this->bytes,
            'consumer_count' => $this->consumerCount,
            'first_seq' => $this->firstSeq,
            'last_seq' => $this->lastSeq,
            'messages' => $this->messages,
            'name' => $this->name,
        ], fn ($val) => $val !== null);
    }
}
