<?php

namespace JeffersonGoncalves\Lemlist\Resources;

use JeffersonGoncalves\Lemlist\LemlistClient;

class Campaigns
{
    public function __construct(
        protected LemlistClient $client,
    ) {}

    /** @param array<string, mixed> $filters */
    public function list(array $filters = []): array
    {
        $query = array_filter([
            'offset' => $filters['offset'] ?? null,
            'limit' => $filters['limit'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get('/campaigns', $query);
    }

    public function get(string $campaignId): array
    {
        return $this->client->get("/campaigns/{$campaignId}");
    }

    public function stats(string $campaignId): array
    {
        return $this->client->get("/campaigns/{$campaignId}/stats");
    }

    public function export(string $campaignId): array
    {
        return $this->client->get("/campaigns/{$campaignId}/export");
    }
}
