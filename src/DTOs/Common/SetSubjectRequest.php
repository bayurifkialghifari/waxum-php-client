<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SetSubjectRequest
{
    public function __construct(
        public readonly string $subject,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            subject: isset($data['subject']) ? (string) $data['subject'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'subject' => $this->subject,
        ], fn ($val) => $val !== null);
    }
}
