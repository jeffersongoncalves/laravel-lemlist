<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Facades\Lemlist;

beforeEach(function () {
    config(['lemlist.api_key' => 'test-key']);
});

it('lists unsubscribes', function () {
    Http::fake(['*unsubscribes*' => Http::response([])]);

    Lemlist::unsubscribes()->list(['limit' => 10]);

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/unsubscribes')
        && $request['limit'] === 10);
});

it('adds an unsubscribe', function () {
    Http::fake(['*unsubscribes/lead%40acme.com*' => Http::response(['status' => 'ok'])]);

    Lemlist::unsubscribes()->add('lead@acme.com');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/unsubscribes/lead%40acme.com'));
});

it('deletes an unsubscribe', function () {
    Http::fake(['*unsubscribes/lead%40acme.com*' => Http::response(['status' => 'ok'])]);

    Lemlist::unsubscribes()->delete('lead@acme.com');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/unsubscribes/lead%40acme.com'));
});
