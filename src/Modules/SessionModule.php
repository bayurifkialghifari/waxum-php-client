<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\ConnectRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\DeviceInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Common\PairCodeRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\PairCodeResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\QrCodeResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Session\CreateSessionResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Session\SessionStatusResponse;
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

    public function getDeviceInfo(string $sessionId, ?string $token = null): DeviceInfo
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/device", [], $token);

        return DeviceInfo::fromArray((array) $data);
    }
}
