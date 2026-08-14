<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

use Bayurifkialghifari\WaxumApi\Exceptions\WaxumApiException;
use Illuminate\Http\Client\Response;

/**
 * Wraps the raw binary (ZIP) response of POST /api/v1/sessions/{id}/export.
 */
class SessionExport
{
    public function __construct(
        public readonly Response $response,
    ) {}

    /**
     * Raw ZIP bytes.
     */
    public function body(): string
    {
        return $this->response->body();
    }

    /**
     * Size of the archive in bytes.
     */
    public function size(): int
    {
        return strlen($this->response->body());
    }

    /**
     * Write the archive to disk.
     *
     * @throws WaxumApiException
     */
    public function saveAs(string $path): string
    {
        if (file_put_contents($path, $this->response->body()) === false) {
            throw new WaxumApiException("Unable to write session export to: {$path}", 500);
        }

        return $path;
    }
}
