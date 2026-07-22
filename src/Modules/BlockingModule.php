<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Blocking\BlockStatusResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\BlocklistResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\BlockRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class BlockingModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function block(string $sessionId, BlockRequest|array|string $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof BlockRequest ? $request->toArray() : (is_string($request) ? ['jid' => $request] : $request);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/blocking/block", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function isBlocked(string $sessionId, string $jid, ?string $token = null): BlockStatusResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/blocking/check/{$jid}", [], $token);

        return BlockStatusResponse::fromArray((array) $data);
    }

    public function getBlocklist(string $sessionId, ?string $token = null): BlocklistResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/blocking/list", [], $token);

        return BlocklistResponse::fromArray((array) $data);
    }

    public function unblock(string $sessionId, BlockRequest|array|string $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof BlockRequest ? $request->toArray() : (is_string($request) ? ['jid' => $request] : $request);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/blocking/unblock", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
