<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Facades\Lemlist;

beforeEach(function () {
    config(['lemlist.api_key' => 'test-key']);
});

it('lists leads for a campaign', function () {
    Http::fake(['*campaigns/camp-1/leads*' => Http::response([])]);

    Lemlist::leads()->list('camp-1', ['limit' => 10]);

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/campaigns/camp-1/leads')
        && $request['limit'] === 10);
});

it('gets a lead by email', function () {
    Http::fake(['*campaigns/camp-1/leads/lead%40acme.com*' => Http::response(['email' => 'lead@acme.com'])]);

    Lemlist::leads()->get('camp-1', 'lead@acme.com');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/campaigns/camp-1/leads/lead%40acme.com'));
});

it('adds a lead', function () {
    Http::fake(['*campaigns/camp-1/leads/*' => Http::response(['status' => 'ok'])]);

    Lemlist::leads()->add('camp-1', 'lead@acme.com', [
        'first-name' => 'Jane',
        'last-name' => 'Doe',
        'company' => 'Acme',
    ]);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request['firstName'] === 'Jane'
        && $request['lastName'] === 'Doe'
        && $request['companyName'] === 'Acme');
});

it('deletes a lead', function () {
    Http::fake(['*campaigns/camp-1/leads/*' => Http::response(['status' => 'ok'])]);

    Lemlist::leads()->delete('camp-1', 'lead@acme.com');

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});
