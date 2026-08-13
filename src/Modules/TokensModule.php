<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Token\MintTokenRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Token\MintTokenResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Token\TokenListResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class TokensModule
{
    public function __construct(protected WaxumApiClient $client) {}

    /**
     * Mint a session-scoped bearer token. The raw token value is only
     * returned here — store it, it can't be retrieved again.
     */
    public function mint(MintTokenRequest|array $request, ?string $token = null): MintTokenResponse
    {
        $payload = $request instanceof MintTokenRequest ? $request->toArray() : $request;
        $data = $this->client->post('/api/v1/tokens', $payload, $token);

        return MintTokenResponse::fromArray((array) $data);
    }

    /**
     * List minted tokens (metadata only, never the bearer value).
     */
    public function list(?string $token = null): TokenListResponse
    {
        $data = $this->client->get('/api/v1/tokens', [], $token);

        return TokenListResponse::fromArray((array) $data);
    }

    /**
     * Revoke a token by its id.
     */
    public function revoke(string $id, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/tokens/{$id}/revoke", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
