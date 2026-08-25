<?php

namespace Adyatama\Quran\Tests;

use Adyatama\Quran\QuranServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [QuranServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('quran.api.url', 'https://api.test/v1');
        $app['config']->set('quran.api.default_query', [
            'source' => 'kemenag',
            'lang' => 'id',
        ]);
        $app['config']->set('quran.api.headers', [
            'X-Tenant-ID' => 'tenant-test',
        ]);
        $app['config']->set('quran.api.key', 'key-test');
        $app['config']->set('quran.api.cache_enabled', false);
    }
}
