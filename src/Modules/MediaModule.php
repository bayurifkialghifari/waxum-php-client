<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Common\UploadMediaResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Media\DownloadMediaRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Media\DownloadMediaResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class MediaModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function download(string $sessionId, DownloadMediaRequest|array $request, ?string $token = null): DownloadMediaResponse
    {
        $payload = $request instanceof DownloadMediaRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/media/download", $payload, $token);

        return DownloadMediaResponse::fromArray((array) $data);
    }

    public function upload(string $sessionId, array $data = [], ?string $token = null): UploadMediaResponse
    {
        $res = $this->client->post("/api/v1/sessions/{$sessionId}/media/upload", $data, $token);

        return UploadMediaResponse::fromArray((array) $res);
    }
}
