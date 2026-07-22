<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Media;

class UploadMediaResponse
{
    public function __construct(
        public readonly string $directPath,
        public readonly string $fileEncSha256,
        public readonly int $fileLength,
        public readonly string $fileSha256,
        public readonly string $mediaKey,
        public readonly mixed $mediaType,
        public readonly string $mimetype,
        public readonly string $url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            directPath: isset($data['direct_path']) ? (string) $data['direct_path'] : null,
            fileEncSha256: isset($data['file_enc_sha256']) ? (string) $data['file_enc_sha256'] : null,
            fileLength: isset($data['file_length']) ? (int) $data['file_length'] : null,
            fileSha256: isset($data['file_sha256']) ? (string) $data['file_sha256'] : null,
            mediaKey: isset($data['media_key']) ? (string) $data['media_key'] : null,
            mediaType: $data['media_type'] ?? null,
            mimetype: isset($data['mimetype']) ? (string) $data['mimetype'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'direct_path' => $this->directPath,
            'file_enc_sha256' => $this->fileEncSha256,
            'file_length' => $this->fileLength,
            'file_sha256' => $this->fileSha256,
            'media_key' => $this->mediaKey,
            'media_type' => $this->mediaType,
            'mimetype' => $this->mimetype,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
