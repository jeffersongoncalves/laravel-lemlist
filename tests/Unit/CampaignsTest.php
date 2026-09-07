<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Exceptions\LemlistException;
use JeffersonGoncalves\Lemlist\Facades\Lemlist;

beforeEach(function () {
    config(['lemlist.api_key' => 'test-key']);
});

it('lists campaigns', function () {
    Http::fake(['*campaigns*' => Http::response([['_id' => 'camp-1']])]);

    Lemlist::campaigns()->list(['limit' => 10]);

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/campaigns')
        && $request['limit'] === 10);
});

it('gets a campaign', function () {
    Http::fake(['*campaigns/camp-1*' => Http::response(['_id' => 'camp-1'])]);

    Lemlist::campaigns()->get('camp-1');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/campaigns/camp-1'));
});

it('gets campaign stats', function () {
    Http::fake(['*campaigns/camp-1/stats*' => Http::response(['sent' => 10])]);

    Lemlist::campaigns()->stats('camp-1');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/campaigns/camp-1/stats'));
});

it('exports a campaign', function () {
    Http::fake(['*campaigns/camp-1/export*' => Http::response(['url' => 'https://export'])]);

    Lemlist::campaigns()->export('camp-1');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/campaigns/camp-1/export'));
});

it('throws on a failed response', function () {
    Http::fake(['*campaigns/missing*' => Http::response(['message' => 'not found'], 404)]);

    Lemlist::campaigns()->get('missing');
})->throws(LemlistException::class, 'not found');
