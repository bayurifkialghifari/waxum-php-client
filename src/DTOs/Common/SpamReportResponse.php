<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SpamReportResponse
{
    public function __construct(
        public readonly ?string $reportId,
        public readonly bool $success,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            reportId: isset($data['report_id']) ? (string) $data['report_id'] : null,
            success: (bool) ($data['success'] ?? false),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'report_id' => $this->reportId,
            'success' => $this->success,
        ], fn ($val) => $val !== null);
    }
}
