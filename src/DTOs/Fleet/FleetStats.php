<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Fleet;

class FleetStats
{
    public function __construct(
        public readonly int $sessionTotal,
        public readonly int $sessionConnected,
        public readonly int $sessionConnecting,
        public readonly int $sessionDisconnected,
        public readonly int $sessionLoggedOut,
        public readonly int $webhookTotal,
        public readonly int $webhookCircuitsOpen,
        public readonly int $eventRatePerMin,
        public readonly int $uptimeSeconds,
        public readonly ?string $version,
        public readonly ?string $storagePath,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            sessionTotal: (int) ($data['session_total'] ?? 0),
            sessionConnected: (int) ($data['session_connected'] ?? 0),
            sessionConnecting: (int) ($data['session_connecting'] ?? 0),
            sessionDisconnected: (int) ($data['session_disconnected'] ?? 0),
            sessionLoggedOut: (int) ($data['session_logged_out'] ?? 0),
            webhookTotal: (int) ($data['webhook_total'] ?? 0),
            webhookCircuitsOpen: (int) ($data['webhook_circuits_open'] ?? 0),
            eventRatePerMin: (int) ($data['event_rate_per_min'] ?? 0),
            uptimeSeconds: (int) ($data['uptime_seconds'] ?? 0),
            version: isset($data['version']) ? (string) $data['version'] : null,
            storagePath: isset($data['storage_path']) ? (string) $data['storage_path'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'session_total' => $this->sessionTotal,
            'session_connected' => $this->sessionConnected,
            'session_connecting' => $this->sessionConnecting,
            'session_disconnected' => $this->sessionDisconnected,
            'session_logged_out' => $this->sessionLoggedOut,
            'webhook_total' => $this->webhookTotal,
            'webhook_circuits_open' => $this->webhookCircuitsOpen,
            'event_rate_per_min' => $this->eventRatePerMin,
            'uptime_seconds' => $this->uptimeSeconds,
            'version' => $this->version,
            'storage_path' => $this->storagePath,
        ], fn ($val) => $val !== null);
    }
}
