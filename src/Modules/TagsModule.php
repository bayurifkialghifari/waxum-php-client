<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Tag\TagCount;
use Bayurifkialghifari\WaxumApi\DTOs\Tag\TagListResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Tag\TagMutateResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class TagsModule
{
    public function __construct(protected WaxumApiClient $client) {}

    /**
     * List every distinct tag across the fleet with session counts.
     *
     * @return TagCount[]
     */
    public function list(?string $token = null): array
    {
        $data = $this->client->get('/api/v1/tags', [], $token);

        return array_map(
            fn (array $tag) => TagCount::fromArray($tag),
            (array) $data,
        );
    }

    /**
     * List tags attached to a session.
     */
    public function forSession(string $sessionId, ?string $token = null): TagListResponse
    {
        $data = $this->client->get("/api/v1/sessions/{$sessionId}/tags", [], $token);

        return TagListResponse::fromArray((array) $data);
    }

    /**
     * Replace the full tag set of a session.
     *
     * @param  string[]  $tags
     */
    public function setTags(string $sessionId, array $tags, ?string $token = null): TagListResponse
    {
        $data = $this->client->put("/api/v1/sessions/{$sessionId}/tags", ['tags' => array_values($tags)], $token);

        return TagListResponse::fromArray((array) $data);
    }

    /**
     * Add a single tag to a session.
     */
    public function add(string $sessionId, string $tag, ?string $token = null): TagMutateResponse
    {
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/tags", ['tag' => $tag], $token);

        return TagMutateResponse::fromArray((array) $data);
    }

    /**
     * Remove a single tag from a session.
     */
    public function remove(string $sessionId, string $tag, ?string $token = null): TagMutateResponse
    {
        $data = $this->client->delete("/api/v1/sessions/{$sessionId}/tags/".rawurlencode($tag), [], $token);

        return TagMutateResponse::fromArray((array) $data);
    }
}
