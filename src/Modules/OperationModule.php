<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\AutoReconnectRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\AutoReconnectResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\HistorySyncRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\HistorySyncResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SpamReportRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SpamReportResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TcTokenGetResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TcTokenIssueRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TcTokenIssueResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TcTokenListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\TcTokenPruneResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class OperationModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function getHistorySync(string $sessionId, ?string $token = null): HistorySyncResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/history-sync", [], $token);

        return HistorySyncResponse::fromArray((array) $data);
    }

    public function setHistorySync(string $sessionId, HistorySyncRequest|array $request, ?string $token = null): HistorySyncResponse
    {
        $payload = $request instanceof HistorySyncRequest ? $request->toArray() : $request;
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/history-sync", $payload, $token);

        return HistorySyncResponse::fromArray((array) $data);
    }

    public function getAutoReconnect(string $sessionId, ?string $token = null): AutoReconnectResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/reconnect", [], $token);

        return AutoReconnectResponse::fromArray((array) $data);
    }

    public function setAutoReconnect(string $sessionId, AutoReconnectRequest|array $request, ?string $token = null): AutoReconnectResponse
    {
        $payload = $request instanceof AutoReconnectRequest ? $request->toArray() : $request;
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/reconnect", $payload, $token);

        return AutoReconnectResponse::fromArray((array) $data);
    }

    public function spamReport(string $sessionId, SpamReportRequest|array $request, ?string $token = null): SpamReportResponse
    {
        $payload = $request instanceof SpamReportRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/spam/report", $payload, $token);

        return SpamReportResponse::fromArray((array) $data);
    }

    public function pruneTcTokens(string $sessionId, ?string $token = null): TcTokenPruneResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/tctoken/expired", [], $token);

        return TcTokenPruneResponse::fromArray((array) $data);
    }

    public function issueTcToken(string $sessionId, TcTokenIssueRequest|array $request, ?string $token = null): TcTokenIssueResponse
    {
        $payload = $request instanceof TcTokenIssueRequest ? $request->toArray() : (is_array($request) && isset($request['jids']) ? $request : ['jids' => $request]);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/tctoken/issue", $payload, $token);

        return TcTokenIssueResponse::fromArray((array) $data);
    }

    public function listTcTokens(string $sessionId, ?string $token = null): TcTokenListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/tctoken/list", [], $token);

        return TcTokenListResponse::fromArray((array) $data);
    }

    public function getTcToken(string $sessionId, string $jid, ?string $token = null): TcTokenGetResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/tctoken/{$jid}", [], $token);

        return TcTokenGetResponse::fromArray((array) $data);
    }
}
