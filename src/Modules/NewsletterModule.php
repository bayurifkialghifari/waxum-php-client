<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\SendResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterAdminInfoResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterFollowersResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterMetadataResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\NewsletterMuteResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\SendNewsletterAdminInviteRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\SendNewsletterFollowerInviteRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Newsletter\SendNewsletterForwardRequest;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class NewsletterModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function sendAdminInvite(string $sessionId, SendNewsletterAdminInviteRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendNewsletterAdminInviteRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/newsletter-admin-invite", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendFollowerInvite(string $sessionId, SendNewsletterFollowerInviteRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendNewsletterFollowerInviteRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/newsletter-follower-invite", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function sendForward(string $sessionId, SendNewsletterForwardRequest|array $request, ?string $token = null): SendResponse
    {
        $payload = $request instanceof SendNewsletterForwardRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/messages/newsletter-forward", $payload, $token);

        return SendResponse::fromArray((array) $data);
    }

    public function subscribed(string $sessionId, ?string $token = null): NewsletterListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/newsletters/subscribed", [], $token);

        return NewsletterListResponse::fromArray((array) $data);
    }

    public function create(string $sessionId, string $name, ?string $description = null, ?string $token = null): NewsletterMetadataResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/newsletters", array_filter([
            'name' => $name,
            'description' => $description,
        ], fn ($val) => $val !== null), $token);

        return NewsletterMetadataResponse::fromArray((array) $data);
    }

    public function metadata(string $sessionId, string $jid, ?string $token = null): NewsletterMetadataResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/metadata", [], $token);

        return NewsletterMetadataResponse::fromArray((array) $data);
    }

    public function join(string $sessionId, string $jid, ?string $token = null): NewsletterMetadataResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/join", [], $token);

        return NewsletterMetadataResponse::fromArray((array) $data);
    }

    public function leave(string $sessionId, string $jid, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/leave", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function delete(string $sessionId, string $jid, ?string $token = null): SuccessResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/newsletters/{$jid}", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function changeOwner(string $sessionId, string $jid, string $user, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/change-owner", [
            'user' => $user,
        ], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function demote(string $sessionId, string $jid, string $user, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/demote", [
            'user' => $user,
        ], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function adminInfo(string $sessionId, string $jid, ?string $token = null): NewsletterAdminInfoResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/admin-info", [], $token);

        return NewsletterAdminInfoResponse::fromArray((array) $data);
    }

    public function followers(string $sessionId, string $jid, ?int $limit = null, ?string $token = null): NewsletterFollowersResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/followers", array_filter([
            'limit' => $limit,
        ]), $token);

        return NewsletterFollowersResponse::fromArray((array) $data);
    }

    public function mute(string $sessionId, string $jid, bool $muted, ?string $token = null): NewsletterMuteResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/newsletters/{$jid}/mute", [
            'muted' => $muted,
        ], $token);

        return NewsletterMuteResponse::fromArray((array) $data);
    }
}
