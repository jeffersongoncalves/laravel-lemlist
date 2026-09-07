<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Lemlist\Facades\Lemlist;

beforeEach(function () {
    config(['lemlist.api_key' => 'test-key']);
});

it('fetches team info', function () {
    Http::fake(['*team*' => Http::response(['_id' => 'team-1'])]);

    Lemlist::team()->info();

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/team')
        && $request->hasHeader('Authorization', 'Basic '.base64_encode(':test-key')));
});
