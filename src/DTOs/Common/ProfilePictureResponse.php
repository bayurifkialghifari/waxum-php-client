<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class ProfilePictureResponse
{
    public function __construct(
        public readonly ?string $directPath = null,
        public readonly ?string $pictureId = null,
        public readonly ?string $url = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            directPath: isset($data['direct_path']) ? (string) $data['direct_path'] : null,
            pictureId: isset($data['picture_id']) ? (string) $data['picture_id'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'direct_path' => $this->directPath,
            'picture_id' => $this->pictureId,
            'url' => $this->url,
        ], fn ($val) => $val !== null);
    }
}
