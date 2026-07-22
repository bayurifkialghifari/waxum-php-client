<?php

namespace Bayurifkialghifari\WaxumApi;

use Bayurifkialghifari\WaxumApi\Exceptions\WaxumApiException;
use Bayurifkialghifari\WaxumApi\Modules\BlastModule;
use Bayurifkialghifari\WaxumApi\Modules\BlockingModule;
use Bayurifkialghifari\WaxumApi\Modules\CallsModule;
use Bayurifkialghifari\WaxumApi\Modules\ChatStateModule;
use Bayurifkialghifari\WaxumApi\Modules\ContactsModule;
use Bayurifkialghifari\WaxumApi\Modules\GroupModule;
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
use Bayurifkialghifari\WaxumApi\Modules\WebhookModule;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class WaxumApiClient
{
    public readonly BlastModule $blast;

    public readonly BlockingModule $blocking;

    public readonly CallsModule $calls;

    public readonly ChatStateModule $chatstate;

    public readonly ContactsModule $contacts;

    public readonly GroupModule $group;

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

    public readonly WebhookModule $webhook;

    public function __construct(
        protected ?string $baseUrl,
        protected ?string $token = null,
    ) {
        $this->blast = new BlastModule($this);
        $this->blocking = new BlockingModule($this);
        $this->calls = new CallsModule($this);
        $this->chatstate = new ChatStateModule($this);
        $this->contacts = new ContactsModule($this);
        $this->group = new GroupModule($this);
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
        $this->webhook = new WebhookModule($this);
    }

    /**
     * Build an HTTP pending request with Bearer authorization header.
     */
    public function http(?string $token = null): PendingRequest
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
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $authorization,
            ]);
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
                'DELETE' => $http->delete($endpoint, $data ?: null),
                default => throw new WaxumApiException("Unsupported HTTP method: {$method}"),
            };

            if ($response->failed()) {
                $body = $response->json() ?? [];
                throw new WaxumApiException(
                    $body['message'] ?? $body['error'] ?? 'Waxum API request failed',
                    $body['code'] ?? $response->status(),
                    $body
                );
            }

            $body = $response->json();

            if (isset($body['success']) && $body['success'] === false) {
                throw new WaxumApiException(
                    $body['error'] ?? $body['message'] ?? 'API request failed',
                    $body['code'] ?? 0,
                    $body
                );
            }

            return $body['data'] ?? $body;
        } catch (RequestException $e) {
            throw new WaxumApiException($e->getMessage(), $e->getCode(), $e);
        }
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

    public function delete(string $endpoint, array $data = [], ?string $token = null): mixed
    {
        return $this->request('DELETE', $endpoint, $data, $token);
    }
}
