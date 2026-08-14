<?php

namespace Bayurifkialghifari\WaxumApi;

use Bayurifkialghifari\WaxumApi\Exceptions\WaxumApiException;
use Bayurifkialghifari\WaxumApi\Modules\BlastModule;
use Bayurifkialghifari\WaxumApi\Modules\BlockingModule;
use Bayurifkialghifari\WaxumApi\Modules\BotsModule;
use Bayurifkialghifari\WaxumApi\Modules\BusinessModule;
use Bayurifkialghifari\WaxumApi\Modules\CallsModule;
use Bayurifkialghifari\WaxumApi\Modules\ChatStateModule;
use Bayurifkialghifari\WaxumApi\Modules\ContactsModule;
use Bayurifkialghifari\WaxumApi\Modules\FleetModule;
use Bayurifkialghifari\WaxumApi\Modules\GroupModule;
use Bayurifkialghifari\WaxumApi\Modules\LabelsModule;
use Bayurifkialghifari\WaxumApi\Modules\MediaModule;
use Bayurifkialghifari\WaxumApi\Modules\MessageModule;
use Bayurifkialghifari\WaxumApi\Modules\MexModule;
use Bayurifkialghifari\WaxumApi\Modules\NatsModule;
use Bayurifkialghifari\WaxumApi\Modules\NewsletterModule;
use Bayurifkialghifari\WaxumApi\Modules\OperationModule;
use Bayurifkialghifari\WaxumApi\Modules\PresenceModule;
use Bayurifkialghifari\WaxumApi\Modules\PrivacyModule;
use Bayurifkialghifari\WaxumApi\Modules\SchedulerModule;
use Bayurifkialghifari\WaxumApi\Modules\SessionModule;
use Bayurifkialghifari\WaxumApi\Modules\StatusModule;
use Bayurifkialghifari\WaxumApi\Modules\TagsModule;
use Bayurifkialghifari\WaxumApi\Modules\TokensModule;
use Bayurifkialghifari\WaxumApi\Modules\WebhookModule;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WaxumApiClient
{
    public readonly BlastModule $blast;

    public readonly BlockingModule $blocking;

    public readonly BotsModule $bots;

    public readonly BusinessModule $business;

    public readonly CallsModule $calls;

    public readonly ChatStateModule $chatstate;

    public readonly ContactsModule $contacts;

    public readonly FleetModule $fleet;

    public readonly GroupModule $group;

    public readonly LabelsModule $labels;

    public readonly MediaModule $media;

    public readonly MessageModule $message;

    public readonly MexModule $mex;

    public readonly NatsModule $nats;

    public readonly NewsletterModule $newsletter;

    public readonly OperationModule $operation;

    public readonly PresenceModule $presence;

    public readonly PrivacyModule $privacy;

    public readonly SchedulerModule $scheduler;

    public readonly SessionModule $session;

    public readonly StatusModule $status;

    public readonly TagsModule $tags;

    public readonly TokensModule $tokens;

    public readonly WebhookModule $webhook;

    public function __construct(
        protected ?string $baseUrl,
        protected ?string $token = null,
    ) {
        $this->blast = new BlastModule($this);
        $this->blocking = new BlockingModule($this);
        $this->bots = new BotsModule($this);
        $this->business = new BusinessModule($this);
        $this->calls = new CallsModule($this);
        $this->chatstate = new ChatStateModule($this);
        $this->contacts = new ContactsModule($this);
        $this->fleet = new FleetModule($this);
        $this->group = new GroupModule($this);
        $this->labels = new LabelsModule($this);
        $this->media = new MediaModule($this);
        $this->message = new MessageModule($this);
        $this->mex = new MexModule($this);
        $this->nats = new NatsModule($this);
        $this->newsletter = new NewsletterModule($this);
        $this->operation = new OperationModule($this);
        $this->presence = new PresenceModule($this);
        $this->privacy = new PrivacyModule($this);
        $this->scheduler = new SchedulerModule($this);
        $this->session = new SessionModule($this);
        $this->status = new StatusModule($this);
        $this->tags = new TagsModule($this);
        $this->tokens = new TokensModule($this);
        $this->webhook = new WebhookModule($this);
    }

    /**
     * Build an HTTP pending request with Bearer authorization header.
     */
    public function http(?string $token = null, array $headers = ['Content-Type' => 'application/json']): PendingRequest
    {
        $resolvedToken = $token ?? $this->token;

        if (! $resolvedToken) {
            throw new WaxumApiException(
                'No authentication token provided. Set WAXUM_TOKEN in your env or pass a token.',
                401
            );
        }

        $authorization = str_starts_with($resolvedToken, 'Bearer ')
            ? $resolvedToken
            : 'Bearer '.$resolvedToken;

        return Http::baseUrl($this->baseUrl)
            ->withHeaders(array_merge($headers, [
                'Authorization' => $authorization,
            ]));
    }

    /**
     * Execute an HTTP request and unwrap the Waxum API response envelope.
     *
     * @throws WaxumApiException
     */
    public function request(string $method, string $endpoint, array $data = [], ?string $token = null): mixed
    {
        try {
            $http = $this->http($token);

            $response = match (strtoupper($method)) {
                'GET' => $http->get($endpoint, $data ?: null),
                'POST' => $http->post($endpoint, $data),
                'PUT' => $http->put($endpoint, $data),
                'PATCH' => $http->patch($endpoint, $data),
                'DELETE' => $http->delete($endpoint, $data ?: null),
                default => throw new WaxumApiException("Unsupported HTTP method: {$method}"),
            };

            if ($response->failed()) {
                throw $this->exceptionFromResponse($response);
            }

            $body = $response->json();

            if (is_array($body) && isset($body['success']) && $body['success'] === false) {
                $rawError = $body['error'] ?? $body['message'] ?? null;
                $message = $this->resolveErrorMessage($rawError, 'API request failed');
                $code = isset($body['code']) && is_numeric($body['code']) ? (int) $body['code'] : 0;

                throw new WaxumApiException($message, $code, $body);
            }

            return is_array($body) && isset($body['data']) ? $body['data'] : $body;
        } catch (RequestException $e) {
            throw new WaxumApiException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Execute a multipart/form-data HTTP request and unwrap the Waxum API response envelope.
     *
     * @param  array<int, array{name: string, contents: mixed, filename?: ?string, headers?: array<string, string>}>  $attachments
     * @param  array<string, mixed>  $fields  Extra text form fields sent alongside the attachments.
     *
     * @throws WaxumApiException
     */
    public function requestMultipart(string $method, string $endpoint, array $attachments, array $fields = [], ?string $token = null): mixed
    {
        try {
            $http = $this->http($token, [])->asMultipart();

            foreach ($attachments as $attachment) {
                $http = $http->attach(
                    $attachment['name'],
                    $attachment['contents'],
                    $attachment['filename'] ?? null,
                    $attachment['headers'] ?? [],
                );
            }

            $response = match (strtoupper($method)) {
                'POST' => $http->post($endpoint, $fields),
                'PUT' => $http->put($endpoint, $fields),
                'PATCH' => $http->patch($endpoint, $fields),
                default => throw new WaxumApiException("Unsupported HTTP method for multipart request: {$method}"),
            };

            if ($response->failed()) {
                throw $this->exceptionFromResponse($response);
            }

            $body = $response->json();

            if (is_array($body) && isset($body['success']) && $body['success'] === false) {
                $rawError = $body['error'] ?? $body['message'] ?? null;
                $message = $this->resolveErrorMessage($rawError, 'API request failed');
                $code = isset($body['code']) && is_numeric($body['code']) ? (int) $body['code'] : 0;

                throw new WaxumApiException($message, $code, $body);
            }

            return is_array($body) && isset($body['data']) ? $body['data'] : $body;
        } catch (RequestException $e) {
            throw new WaxumApiException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Execute an HTTP request and return the raw response without unwrapping
     * the JSON envelope (for binary downloads such as ZIP/WAV payloads).
     *
     * @throws WaxumApiException
     */
    public function requestRaw(string $method, string $endpoint, array $data = [], ?string $token = null): Response
    {
        try {
            $http = $this->http($token);

            $response = match (strtoupper($method)) {
                'GET' => $http->get($endpoint, $data ?: null),
                'POST' => $http->post($endpoint, $data),
                default => throw new WaxumApiException("Unsupported HTTP method for raw request: {$method}"),
            };

            if ($response->failed()) {
                throw $this->exceptionFromResponse($response);
            }

            return $response;
        } catch (RequestException $e) {
            throw new WaxumApiException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Build a WaxumApiException from a failed HTTP response.
     */
    protected function exceptionFromResponse(Response $response): WaxumApiException
    {
        $body = is_array($response->json()) ? $response->json() : [];
        $rawError = $body['message'] ?? $body['error'] ?? null;
        $message = $this->resolveErrorMessage($rawError, 'Waxum API request failed');
        $code = isset($body['code']) && is_numeric($body['code']) ? (int) $body['code'] : $response->status();

        return new WaxumApiException($message, $code, $body);
    }

    /**
     * Resolve error message into a human-readable string.
     */
    protected function resolveErrorMessage(mixed $error, string $default): string
    {
        if (is_string($error) && trim($error) !== '') {
            return $error;
        }

        if (is_array($error)) {
            if (isset($error['message']) && is_string($error['message'])) {
                return $error['message'];
            }
            if (isset($error['error']) && is_string($error['error'])) {
                return $error['error'];
            }

            $stringItems = array_filter(array_values($error), fn ($item) => is_string($item) && trim($item) !== '');
            if (! empty($stringItems)) {
                return implode(', ', $stringItems);
            }

            $encoded = json_encode($error);
            if ($encoded !== false) {
                return $encoded;
            }
        }

        return $default;
    }

    public function get(string $endpoint, array $query = [], ?string $token = null): mixed
    {
        return $this->request('GET', $endpoint, $query, $token);
    }

    public function post(string $endpoint, array $data = [], ?string $token = null): mixed
    {
        return $this->request('POST', $endpoint, $data, $token);
    }

    public function put(string $endpoint, array $data = [], ?string $token = null): mixed
    {
        return $this->request('PUT', $endpoint, $data, $token);
    }

    public function patch(string $endpoint, array $data = [], ?string $token = null): mixed
    {
        return $this->request('PATCH', $endpoint, $data, $token);
    }

    public function delete(string $endpoint, array $data = [], ?string $token = null): mixed
    {
        return $this->request('DELETE', $endpoint, $data, $token);
    }
}
