<?php

namespace JeffersonGoncalves\Lemlist\Tests;

use JeffersonGoncalves\Lemlist\LemlistServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LemlistServiceProvider::class,
        ];
    }
}
