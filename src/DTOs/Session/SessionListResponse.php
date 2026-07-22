<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

class SessionListResponse
{
    /**
     * @param  array<int, SessionInfo>  $sessions
     */
    public function __construct(
        public readonly array $sessions,
        public readonly ?int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        $rawSessions = (array) ($data['sessions'] ?? []);
        $sessions = array_map(
            fn ($item) => is_array($item) ? SessionInfo::fromArray($item) : $item,
            $rawSessions
        );

        return new self(
            sessions: $sessions,
            total: isset($data['total']) ? (int) $data['total'] : null,
        );
    }

    public function toArray(): array
    {
        $sessionsArray = array_map(
            fn ($item) => $item instanceof SessionInfo ? $item->toArray() : $item,
            $this->sessions
        );

        return array_filter([
            'sessions' => $sessionsArray,
            'total' => $this->total,
        ], fn ($val) => $val !== null);
    }
}
