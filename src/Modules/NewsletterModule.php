<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\SendResponse;
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
}
