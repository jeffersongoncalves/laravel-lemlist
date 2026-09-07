<?php

namespace JeffersonGoncalves\Lemlist\Resources;

use JeffersonGoncalves\Lemlist\LemlistClient;

class Webhooks
{
    public function __construct(
        protected LemlistClient $client,
    ) {}

    public function list(): array
    {
        return $this->client->get('/hooks');
    }

    public function create(string $targetUrl, string $event): array
    {
        return $this->client->post('/hooks', [
            'targetUrl' => $targetUrl,
            'event' => $event,
        ]);
    }

    public function delete(string $id): array
    {
        return $this->client->delete("/hooks/{$id}");
    }
}
