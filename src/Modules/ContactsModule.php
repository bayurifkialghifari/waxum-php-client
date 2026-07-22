<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\CheckOnWhatsAppRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\CheckOnWhatsAppResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\ContactInfoResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\GetContactInfoRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\GetUserInfoRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\ProfilePictureResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\StoredContactListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\UserInfoResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class ContactsModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function list(
        string $sessionId,
        ?string $q = null,
        ?int $limit = null,
        ?int $offset = null,
        ?string $token = null
    ): StoredContactListResponse {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/contacts", array_filter([
            'q' => $q,
            'limit' => $limit,
            'offset' => $offset,
        ]), $token);

        return StoredContactListResponse::fromArray((array) $data);
    }

    public function checkOnWhatsApp(string $sessionId, CheckOnWhatsAppRequest|array $request, ?string $token = null): CheckOnWhatsAppResponse
    {
        $payload = $request instanceof CheckOnWhatsAppRequest ? $request->toArray() : (is_array($request) && isset($request['phone_numbers']) ? $request : ['phone_numbers' => $request]);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/contacts/check", $payload, $token);

        return CheckOnWhatsAppResponse::fromArray((array) $data);
    }

    public function getContactInfo(string $sessionId, GetContactInfoRequest|array $request, ?string $token = null): ContactInfoResponse
    {
        $payload = $request instanceof GetContactInfoRequest ? $request->toArray() : (is_array($request) && isset($request['jids']) ? $request : ['jids' => $request]);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/contacts/info", $payload, $token);

        return ContactInfoResponse::fromArray((array) $data);
    }

    public function getUserInfo(string $sessionId, GetUserInfoRequest|array $request, ?string $token = null): UserInfoResponse
    {
        $payload = $request instanceof GetUserInfoRequest ? $request->toArray() : (is_array($request) && isset($request['jids']) ? $request : ['jids' => $request]);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/contacts/users", $payload, $token);

        return UserInfoResponse::fromArray((array) $data);
    }

    public function getProfilePicture(string $sessionId, string $jid, ?string $token = null): ProfilePictureResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/contacts/{$jid}/picture", [], $token);

        return ProfilePictureResponse::fromArray((array) $data);
    }
}
