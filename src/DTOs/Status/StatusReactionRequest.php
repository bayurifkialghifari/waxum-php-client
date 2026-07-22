<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Status;

class StatusReactionRequest
{
    public function __construct(
        public readonly string $messageId,
        public readonly string $reaction,
        public readonly string $statusOwner,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            messageId: isset($data['message_id']) ? (string) $data['message_id'] : null,
            reaction: isset($data['reaction']) ? (string) $data['reaction'] : null,
            statusOwner: isset($data['status_owner']) ? (string) $data['status_owner'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'message_id' => $this->messageId,
            'reaction' => $this->reaction,
            'status_owner' => $this->statusOwner,
        ], fn ($val) => $val !== null);
    }
}
