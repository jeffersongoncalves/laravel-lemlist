<?php

namespace JeffersonGoncalves\Lemlist\Resources;

use JeffersonGoncalves\Lemlist\LemlistClient;

class Team
{
    public function __construct(
        protected LemlistClient $client,
    ) {}

    public function info(): array
    {
        return $this->client->get('/team');
    }
}
