<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Facades\Lemlist;

beforeEach(function () {
    config(['lemlist.api_key' => 'test-key']);
});

it('lists activities with filters', function () {
    Http::fake(['*activities*' => Http::response([])]);

    Lemlist::activities()->list(['campaignId' => 'camp-1', 'type' => 'emailsSent']);

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/activities')
        && $request['campaignId'] === 'camp-1'
        && $request['type'] === 'emailsSent');
});
