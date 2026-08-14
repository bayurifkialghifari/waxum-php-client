<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Labels\CreateLabelRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Labels\MessageLabelRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Labels\QuickReplyRequest;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class LabelsModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function createLabel(string $sessionId, CreateLabelRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof CreateLabelRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/labels", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function deleteLabel(string $sessionId, string $labelId, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/labels/{$labelId}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function addChatToLabel(string $sessionId, string $labelId, string $chatJid, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/labels/{$labelId}/chats/{$chatJid}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function removeChatFromLabel(string $sessionId, string $labelId, string $chatJid, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/labels/{$labelId}/chats/{$chatJid}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function addMessageToLabel(string $sessionId, string $labelId, MessageLabelRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof MessageLabelRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/labels/{$labelId}/messages", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function removeMessageFromLabel(string $sessionId, string $labelId, MessageLabelRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof MessageLabelRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/labels/{$labelId}/messages/remove", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function setQuickReply(string $sessionId, QuickReplyRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof QuickReplyRequest ? $request->toArray() : $request;
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/quick-replies", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function deleteQuickReply(string $sessionId, string $id, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/quick-replies/{$id}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function setLinkPreviews(string $sessionId, bool $disabled, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/settings/link-previews", [
            'disabled' => $disabled,
        ], $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
