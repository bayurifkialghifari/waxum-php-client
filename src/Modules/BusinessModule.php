<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessCatalogResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessCollectionsResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessOrderResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Business\BusinessProfileUpdateRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class BusinessModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function catalog(string $sessionId, string $jid, ?int $limit = null, ?int $width = null, ?int $height = null, ?string $after = null, ?string $token = null): BusinessCatalogResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/business/catalog", array_filter([
            'jid' => $jid,
            'limit' => $limit,
            'width' => $width,
            'height' => $height,
            'after' => $after,
        ]), $token);

        return BusinessCatalogResponse::fromArray((array) $data);
    }

    public function collections(string $sessionId, string $jid, ?int $limit = null, ?int $itemLimit = null, ?int $width = null, ?int $height = null, ?string $after = null, ?string $token = null): BusinessCollectionsResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/business/collections", array_filter([
            'jid' => $jid,
            'limit' => $limit,
            'item_limit' => $itemLimit,
            'width' => $width,
            'height' => $height,
            'after' => $after,
        ]), $token);

        return BusinessCollectionsResponse::fromArray((array) $data);
    }

    public function order(string $sessionId, string $jid, string $orderId, string $orderToken, ?int $width = null, ?int $height = null, ?string $token = null): BusinessOrderResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/business/order", array_filter([
            'jid' => $jid,
            'order_id' => $orderId,
            'token' => $orderToken,
            'width' => $width,
            'height' => $height,
        ]), $token);

        return BusinessOrderResponse::fromArray((array) $data);
    }

    public function updateProfile(string $sessionId, BusinessProfileUpdateRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof BusinessProfileUpdateRequest ? $request->toArray() : $request;
        $data = $this->client->patch("/api/v1/sessions/{$sessionId}/business/profile", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function deleteCoverPhoto(string $sessionId, string $photoId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/business/cover-photo/{$photoId}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
