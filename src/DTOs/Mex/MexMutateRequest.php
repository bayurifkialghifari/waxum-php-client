<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Mex;

class MexMutateRequest
{
    public function __construct(
        public readonly string $docId,
        public readonly ?string $docName,
        public readonly mixed $variables,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            docId: isset($data['doc_id']) ? (string) $data['doc_id'] : null,
            docName: isset($data['doc_name']) ? (string) $data['doc_name'] : null,
            variables: $data['variables'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'doc_id' => $this->docId,
            'doc_name' => $this->docName,
            'variables' => $this->variables,
        ], fn ($val) => $val !== null);
    }
}
