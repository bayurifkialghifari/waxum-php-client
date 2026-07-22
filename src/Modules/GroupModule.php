<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\InviteLinkResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\ParticipantsRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\ParticipantsResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SetDescriptionRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SetGroupSettingsRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SetSubjectRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Group\CreateGroupRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Group\CreateGroupResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Group\GroupInfo;
use Bayurifkialghifari\WaxumApi\DTOs\Group\GroupInfoCached;
use Bayurifkialghifari\WaxumApi\DTOs\Group\GroupListResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class GroupModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function list(string $sessionId, ?string $token = null): GroupListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/groups", [], $token);

        return GroupListResponse::fromArray((array) $data);
    }

    public function create(string $sessionId, CreateGroupRequest|array $request, ?string $token = null): CreateGroupResponse
    {
        $payload = $request instanceof CreateGroupRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/groups", $payload, $token);

        return CreateGroupResponse::fromArray((array) $data);
    }

    public function get(string $sessionId, string $groupJid, ?string $token = null): GroupInfo
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/groups/{$groupJid}", [], $token);

        return GroupInfo::fromArray((array) $data);
    }

    public function promoteParticipants(string $sessionId, string $groupJid, ParticipantsRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof ParticipantsRequest ? $request->toArray() : (is_array($request) && isset($request['participants']) ? $request : ['participants' => $request]);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/admins", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function demoteParticipants(string $sessionId, string $groupJid, ParticipantsRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof ParticipantsRequest ? $request->toArray() : (is_array($request) && isset($request['participants']) ? $request : ['participants' => $request]);
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/admins", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function setDescription(string $sessionId, string $groupJid, SetDescriptionRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof SetDescriptionRequest ? $request->toArray() : $request;
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/description", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function getInfo(string $sessionId, string $groupJid, ?string $token = null): GroupInfoCached
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/info", [], $token);

        return GroupInfoCached::fromArray((array) $data);
    }

    public function getInviteLink(string $sessionId, string $groupJid, ?bool $reset = null, ?string $token = null): InviteLinkResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/invite-link", array_filter([
            'reset' => $reset,
        ]), $token);

        return InviteLinkResponse::fromArray((array) $data);
    }

    public function leave(string $sessionId, string $groupJid, ?string $token = null): SuccessResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/leave", [], $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function addParticipants(string $sessionId, string $groupJid, ParticipantsRequest|array $request, ?string $token = null): ParticipantsResponse
    {
        $payload = $request instanceof ParticipantsRequest ? $request->toArray() : (is_array($request) && isset($request['participants']) ? $request : ['participants' => $request]);
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/participants", $payload, $token);

        return ParticipantsResponse::fromArray((array) $data);
    }

    public function removeParticipants(string $sessionId, string $groupJid, ParticipantsRequest|array $request, ?string $token = null): ParticipantsResponse
    {
        $payload = $request instanceof ParticipantsRequest ? $request->toArray() : (is_array($request) && isset($request['participants']) ? $request : ['participants' => $request]);
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/participants", $payload, $token);

        return ParticipantsResponse::fromArray((array) $data);
    }

    public function setSettings(string $sessionId, string $groupJid, SetGroupSettingsRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof SetGroupSettingsRequest ? $request->toArray() : $request;
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/settings", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }

    public function setSubject(string $sessionId, string $groupJid, SetSubjectRequest|array $request, ?string $token = null): SuccessResponse
    {
        $payload = $request instanceof SetSubjectRequest ? $request->toArray() : (is_array($request) && isset($request['subject']) ? $request : ['subject' => $request]);
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/groups/{$groupJid}/subject", $payload, $token);

        return SuccessResponse::fromArray((array) $data);
    }
}
