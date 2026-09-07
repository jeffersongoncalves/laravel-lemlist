<?php

namespace JeffersonGoncalves\Lemlist\Resources;

use JeffersonGoncalves\Lemlist\LemlistClient;

class Unsubscribes
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

        return $this->client->get('/unsubscribes', $query);
    }

    public function add(string $email): array
    {
        return $this->client->post('/unsubscribes/'.urlencode($email));
    }

    public function delete(string $email): array
    {
        return $this->client->delete('/unsubscribes/'.urlencode($email));
    }
}
