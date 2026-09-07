<?php

namespace JeffersonGoncalves\Lemlist\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\Lemlist\Lemlist
 */
class Lemlist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Lemlist\Lemlist::class;
    }
}
