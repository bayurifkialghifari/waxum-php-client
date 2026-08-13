<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Fleet;

class ReadyzResponse
{
    /**
     * @param  ReadyzSession[]  $sessions
     */
    public function __construct(
        public readonly string $db,
        public readonly int $sessionsKnown,
        public readonly int $sessionsLive,
        public readonly array $sessions,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            db: (string) ($data['db'] ?? ''),
            sessionsKnown: (int) ($data['sessions_known'] ?? 0),
            sessionsLive: (int) ($data['sessions_live'] ?? 0),
            sessions: array_map(
                fn (array $session) => ReadyzSession::fromArray($session),
                (array) ($data['sessions'] ?? []),
            ),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'db' => $this->db,
            'sessions_known' => $this->sessionsKnown,
            'sessions_live' => $this->sessionsLive,
            'sessions' => array_map(fn (ReadyzSession $session) => $session->toArray(), $this->sessions),
        ], fn ($val) => $val !== null);
    }
}
