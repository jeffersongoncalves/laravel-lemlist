<?php

namespace JeffersonGoncalves\Lemlist;

use JeffersonGoncalves\Lemlist\Resources\Activities;
use JeffersonGoncalves\Lemlist\Resources\Campaigns;
use JeffersonGoncalves\Lemlist\Resources\Leads;
use JeffersonGoncalves\Lemlist\Resources\Team;
use JeffersonGoncalves\Lemlist\Resources\Unsubscribes;
use JeffersonGoncalves\Lemlist\Resources\Webhooks;

/**
 * Entry point exposing one resource per Lemlist REST API group.
 */
class Lemlist
{
    protected LemlistClient $client;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.lemlist.com/api')
    {
        $this->client = new LemlistClient($apiKey, $baseUrl);
    }

    public function team(): Team
    {
        return new Team($this->client);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this->client);
    }

    public function leads(): Leads
    {
        return new Leads($this->client);
    }

    public function unsubscribes(): Unsubscribes
    {
        return new Unsubscribes($this->client);
    }

    public function activities(): Activities
    {
        return new Activities($this->client);
    }

    public function webhooks(): Webhooks
    {
        return new Webhooks($this->client);
    }
}
