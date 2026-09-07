<?php

namespace JeffersonGoncalves\Lemlist;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Exceptions\LemlistException;

/**
 * Thin wrapper around Laravel's Http client for the Lemlist REST API.
 *
 * Lemlist authenticates via HTTP Basic auth: the API key as the password
 * with an empty username, sent as an `Authorization: Basic base64(":$key")`
 * header on every request — unlike Instantly's query/body `api_key` param.
 *
 * ponytail: Http::retry() already covers transient-failure retries if ever
 * needed later — no custom retry/backoff layer built here speculatively.
 */
class LemlistClient
{
    public function __construct(
        protected string $apiKey,
        protected string $baseUrl = 'https://api.lemlist.com/api',
    ) {}

    protected function request(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'Authorization' => 'Basic '.base64_encode(":{$this->apiKey}"),
                'Accept' => 'application/json',
            ])
            ->acceptJson();
    }

    /** @param array<string, mixed> $query */
    public function get(string $path, array $query = []): array
    {
        $response = $this->request()->get($path, $query);

        if ($response->failed()) {
            throw LemlistException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }

    /** @param array<string, mixed> $body */
    public function post(string $path, array $body = []): array
    {
        $response = $this->request()->post($path, $body);

        if ($response->failed()) {
            throw LemlistException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }

    public function delete(string $path): array
    {
        $response = $this->request()->delete($path);

        if ($response->failed()) {
            throw LemlistException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }
}
