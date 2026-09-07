<?php

namespace JeffersonGoncalves\Lemlist\Resources;

use JeffersonGoncalves\Lemlist\LemlistClient;

class Leads
{
    public function __construct(
        protected LemlistClient $client,
    ) {}

    /** @param array<string, mixed> $filters */
    public function list(string $campaignId, array $filters = []): array
    {
        $query = array_filter([
            'offset' => $filters['offset'] ?? null,
            'limit' => $filters['limit'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get("/campaigns/{$campaignId}/leads", $query);
    }

    public function get(string $campaignId, string $email): array
    {
        return $this->client->get("/campaigns/{$campaignId}/leads/".urlencode($email));
    }

    /** @param array<string, mixed> $attributes first-name, last-name, company, ... */
    public function add(string $campaignId, string $email, array $attributes = []): array
    {
        $body = array_filter([
            'firstName' => $attributes['first-name'] ?? null,
            'lastName' => $attributes['last-name'] ?? null,
            'companyName' => $attributes['company'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->post("/campaigns/{$campaignId}/leads/".urlencode($email), $body);
    }

    public function delete(string $campaignId, string $email): array
    {
        return $this->client->delete("/campaigns/{$campaignId}/leads/".urlencode($email));
    }
}
