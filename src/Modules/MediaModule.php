<?php

namespace Bayurifkialghifari\WaxumApi\Modules;

use Bayurifkialghifari\WaxumApi\DTOs\Media\DownloadMediaRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Media\DownloadMediaResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Media\UploadMediaResponse;
use Bayurifkialghifari\WaxumApi\Exceptions\WaxumApiException;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;

class MediaModule
{
    public function __construct(protected WaxumApiClient $client) {}

    public function download(string $sessionId, DownloadMediaRequest|array $request, ?string $token = null): DownloadMediaResponse
    {
        $payload = $request instanceof DownloadMediaRequest ? $request->toArray() : $request;
        $data = $this->client->post("/api/v1/sessions/{$sessionId}/media/download", $payload, $token);

        return DownloadMediaResponse::fromArray($data);
    }

    /**
     * Upload a media file (multipart/form-data, 100 MB limit on the server).
     *
     * @throws WaxumApiException
     */
    public function upload(
        string $sessionId,
        string $filePath,
        ?string $mediaType = null,
        ?string $mimetype = null,
        ?string $token = null,
    ): UploadMediaResponse {
        if (! is_file($filePath) || ! is_readable($filePath)) {
            throw new WaxumApiException("File not found or not readable: {$filePath}", 400);
        }

        $contents = fopen($filePath, 'r');

        if ($contents === false) {
            throw new WaxumApiException("Unable to open file: {$filePath}", 400);
        }

        $fields = array_filter([
            'media_type' => $mediaType,
            'mimetype' => $mimetype,
        ], fn ($val) => $val !== null);

        $res = $this->client->requestMultipart(
            'POST',
            "/api/v1/sessions/{$sessionId}/media/upload",
            [
                [
                    'name' => 'file',
                    'contents' => $contents,
                    'filename' => basename($filePath),
                ],
            ],
            $fields,
            $token,
        );

        return UploadMediaResponse::fromArray((array) $res);
    }
}
