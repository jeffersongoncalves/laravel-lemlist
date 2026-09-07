<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Facades\Lemlist;

beforeEach(function () {
    config(['lemlist.api_key' => 'test-key']);
});

it('lists webhooks', function () {
    Http::fake(['*hooks*' => Http::response([])]);

    Lemlist::webhooks()->list();

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/hooks'));
});

it('creates a webhook', function () {
    Http::fake(['*hooks*' => Http::response(['_id' => 'hook-1'])]);

    Lemlist::webhooks()->create('https://example.com/hook', 'emailsOpened');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request['targetUrl'] === 'https://example.com/hook'
        && $request['event'] === 'emailsOpened');
});

it('deletes a webhook', function () {
    Http::fake(['*hooks/hook-1*' => Http::response(['status' => 'ok'])]);

    Lemlist::webhooks()->delete('hook-1');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/hooks/hook-1'));
});
