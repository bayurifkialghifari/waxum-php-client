<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\ConnectRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\DeviceInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Common\PairCodeRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\PairCodeResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\QrCodeResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\AppStateResyncMode;
use Bayurifkialghifari\WaxumApi\DTOs\Session\AppStateResyncResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\DisconnectAllResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\PauseStateResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\PurgeResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\ReconnectAllResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SearchResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionExport;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionStatusResponse;
use Bayurifkialghifari\WaxumApi\Exceptions\WaxumApiException;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class SessionModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function list(?string $token = null): SessionListResponse
    {
        $data = $this->client->get('/api/v1/sessions', [], $token);

        return SessionListResponse::fromArray((array) $data);
    }

    public function create(CreateSessionRequest|array $request, ?string $token = null): CreateSessionResponse
    {
        $payload = $request instanceof CreateSessionRequest ? $request->toArray() : $request;
        $data = $this->client->post('/api/v1/sessions', $payload, $token);

        return CreateSessionResponse::fromArray((array) $data);
    }

    public function get(string $sessionId, ?string $token = null): SessionInfo
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}", [], $token);

        return SessionInfo::fromArray((array) $data);
    }

    public function delete(string $sessionId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function connect(string $sessionId, ConnectRequest|array $request = [], ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof ConnectRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/connect", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function disconnect(string $sessionId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/disconnect", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function pair(string $sessionId, PairCodeRequest|array $request = [], ?string $token = null): PairCodeResponse
    {
        $payload = $request instanceof PairCodeRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/pair", $payload, $token);

        return PairCodeResponse::fromArray((array) $data);
    }

    public function getQrCode(string $sessionId, ?string $token = null): QrCodeResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/qr", [], $token);

        return QrCodeResponse::fromArray((array) $data);
    }

    public function getStatus(string $sessionId, ?string $token = null): SessionStatusResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/status", [], $token);

        return SessionStatusResponse::fromArray((array) $data);
    }

    public function pause(string $sessionId, ?string $token = null): PauseStateResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/pause", [], $token);

        return PauseStateResponse::fromArray((array) $data);
    }

    public function resume(string $sessionId, ?string $token = null): PauseStateResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/resume", [], $token);

        return PauseStateResponse::fromArray((array) $data);
    }

    /**
     * Re-fetch app-state collections (e.g. `critical_block`, `regular_low`).
     * `mode` defaults to incremental on the server when omitted.
     *
     * @param  string[]  $collections
     */
    public function resyncAppState(string $sessionId, array $collections, AppStateResyncMode|string|null $mode = null, ?string $token = null): AppStateResyncResponse
    {
        $mode = $mode instanceof AppStateResyncMode ? $mode->value : $mode;

        $payload = array_filter([
            'collections' => array_values($collections),
            'mode' => $mode,
        ], fn ($val) => $val !== null);

        $data = $this->client->post("/api/v1/sessions/{$sessionId}/appstate/resync", $payload, $token);

        return AppStateResyncResponse::fromArray((array) $data);
    }

    public function getDeviceInfo(string $sessionId, ?string $token = null): DeviceInfo
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/device", [], $token);

        return DeviceInfo::fromArray((array) $data);
    }

    /**
     * Purge sessions matching a filter (e.g. inactive for N days).
     *
     * @param  array{filter?: string, days?: int, dry_run?: bool}  $filter
     */
    public function purge(array $filter = [], ?string $token = null): PurgeResponse
    {
        $query = array_filter([
            'filter' => isset($filter['filter']) ? (string) $filter['filter'] : null,
            'days' => isset($filter['days']) ? (int) $filter['days'] : null,
            'dry_run' => isset($filter['dry_run']) ? ($filter['dry_run'] ? 'true' : 'false') : null,
        ], fn ($val) => $val !== null);

        $endpoint = '/api/v1/sessions/purge';
        if ($query !== []) {
            $endpoint .= '?'.http_build_query($query);
        }

        $data = $this->client->post($endpoint, [], $token);

        return PurgeResponse::fromArray((array) $data);
    }

    public function disconnectAll(?string $token = null): DisconnectAllResponse
    {
        $data = $this->client->post('/api/v1/sessions/disconnect-all', [], $token);

        return DisconnectAllResponse::fromArray((array) $data);
    }

    public function reconnectAll(?string $token = null): ReconnectAllResponse
    {
        $data = $this->client->post('/api/v1/sessions/reconnect-all', [], $token);

        return ReconnectAllResponse::fromArray((array) $data);
    }

    /**
     * Search sessions by id, name, phone_number, or push_name.
     */
    public function search(string $q, ?string $token = null): SearchResponse
    {
        $data = $this->client->get('/api/v1/sessions/search', ['q' => $q], $token);

        return SearchResponse::fromArray((array) $data);
    }

    /**
     * Export a session's local storage as a ZIP archive (binary download).
     */
    public function export(string $sessionId, ?string $token = null): SessionExport
    {
        $response = $this->client->requestRaw('POST', "/api/v1/sessions/{$sessionId}/export", [], $token);

        return new SessionExport($response);
    }

    /**
     * Import a session storage ZIP archive (multipart upload, field name `file`).
     *
     * @throws WaxumApiException
     */
    public function import(string $sessionId, string $filePath, ?string $token = null): SuccessResponse
    {
        if (! is_file($filePath) || ! is_readable($filePath)) {
            throw new WaxumApiException("File not found or not readable: {$filePath}", 400);
        }

        $contents = fopen($filePath, 'r');

        if ($contents === false) {
            throw new WaxumApiException("Unable to open file: {$filePath}", 400);
        }

        $data = $this->client->requestMultipart(
            'POST',
            "/api/v1/sessions/{$sessionId}/import",
            [
                [
                    'name' => 'file',
                    'contents' => $contents,
                    'filename' => basename($filePath),
                ],
            ],
            [],
            $token,
        );

        return SuccessResponse::fromArray((array) $data);
    }
}
