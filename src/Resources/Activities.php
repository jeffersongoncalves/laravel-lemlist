<?php

namespace JeffersonGoncalves\Lemlist\Resources;

use JeffersonGoncalves\Lemlist\LemlistClient;

class Activities
{
    public function __construct(
        protected LemlistClient $client,
    ) {}

    /** @param array<string, mixed> $filters campaignId, type, offset, limit */
    public function list(array $filters = []): array
    {
        $query = array_filter([
            'campaignId' => $filters['campaignId'] ?? null,
            'type' => $filters['type'] ?? null,
            'offset' => $filters['offset'] ?? null,
            'limit' => $filters['limit'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get('/activities', $query);
    }
}
