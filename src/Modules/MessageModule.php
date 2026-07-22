<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\MarkAsReadRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\RequestPaymentRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendAudioRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendButtonsRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendButtonsResponseRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendContactRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendDocumentRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendImageRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendInteractiveRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendInteractiveResponseRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendListRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendListResponseRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendLocationRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendOrderRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendPaymentInviteRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendPaymentRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendPollRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendPollUpdateRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendScheduledCallEditRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendScheduledCallRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendStickerRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendTextRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SendVideoRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Message\EditMessageRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Message\ForwardMessageRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Message\MessageResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Message\MessageSearchResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Message\RevokeMessageRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Message\SendPinMessageRequest;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class MessageModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function sendText(string $sessionId, SendTextRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendTextRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/text", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendImage(string $sessionId, SendImageRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendImageRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/image", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendAudio(string $sessionId, SendAudioRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendAudioRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/audio", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendVideo(string $sessionId, SendVideoRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendVideoRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/video", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendDocument(string $sessionId, SendDocumentRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendDocumentRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/document", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendLocation(string $sessionId, SendLocationRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendLocationRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/location", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendContact(string $sessionId, SendContactRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendContactRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/contact", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendPoll(string $sessionId, SendPollRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendPollRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/poll", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendPollUpdate(string $sessionId, SendPollUpdateRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendPollUpdateRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/poll-update", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendSticker(string $sessionId, SendStickerRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendStickerRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/sticker", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendButtons(string $sessionId, SendButtonsRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendButtonsRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/buttons", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendButtonsResponse(string $sessionId, SendButtonsResponseRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendButtonsResponseRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/buttons-response", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendList(string $sessionId, SendListRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendListRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/list", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendListResponse(string $sessionId, SendListResponseRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendListResponseRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/list-response", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendInteractive(string $sessionId, SendInteractiveRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendInteractiveRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/interactive", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendInteractiveResponse(string $sessionId, SendInteractiveResponseRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendInteractiveResponseRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/interactive-response", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendOrder(string $sessionId, SendOrderRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendOrderRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/order", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendPayment(string $sessionId, SendPaymentRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendPaymentRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/send-payment", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function requestPayment(string $sessionId, RequestPaymentRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof RequestPaymentRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/request-payment", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendPaymentInvite(string $sessionId, SendPaymentInviteRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendPaymentInviteRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/payment-invite", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendPinMessage(string $sessionId, SendPinMessageRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendPinMessageRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/pin", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function markAsRead(string $sessionId, MarkAsReadRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof MarkAsReadRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/read", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function revokeMessage(string $sessionId, RevokeMessageRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof RevokeMessageRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/revoke", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function editMessage(string $sessionId, EditMessageRequest|array $request, ?string $token = null): MessageResponse
    {
        $payload = $request instanceof EditMessageRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/edit", $payload, $token);

        return MessageResponse::fromArray((array) $data);
    }

    public function forwardMessage(string $sessionId, ForwardMessageRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof ForwardMessageRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/forward", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendScheduledCall(string $sessionId, SendScheduledCallRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendScheduledCallRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/scheduled-call", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendScheduledCallEdit(string $sessionId, SendScheduledCallEditRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendScheduledCallEditRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/scheduled-call-edit", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function searchAll(string $q, ?string $session = null, ?int $limit = null, ?int $offset = null, ?string $token = null): MessageSearchResponse
    {
        $data = $this->client->get('/api/v1/messages/search', array_filter([
            'q' => $q,
            'session' => $session,
            'limit' => $limit,
            'offset' => $offset,
        ]), $token);

        return MessageSearchResponse::fromArray((array) $data);
    }

    public function searchSessionMessages(string $sessionId, string $q, ?int $limit = null, ?int $offset = null, ?string $token = null): MessageSearchResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/messages/search", array_filter([
            'q' => $q,
            'limit' => $limit,
            'offset' => $offset,
        ]), $token);

        return MessageSearchResponse::fromArray((array) $data);
    }
}
