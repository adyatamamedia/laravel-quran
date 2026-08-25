<?php

namespace Adyatama\Quran\Tests\Unit;

use Adyatama\Quran\Services\IslamiApi\ApiClient;
use Adyatama\Quran\Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class ApiClientTest extends TestCase
{
    public function test_default_query_and_custom_headers_are_sent(): void
    {
        Http::fake([
            'https://api.test/*' => Http::response(['success' => true, 'data' => ['ok' => true]]),
        ]);

        $client = app(ApiClient::class);
        $result = $client->get('quran/surahs', ['page' => 2]);

        $this->assertSame(['ok' => true], $result);
        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://api.test/v1/quran/surahs?source=kemenag&lang=id&page=2'
                && $request->header('X-Tenant-ID') === ['tenant-test']
                && $request->header('X-Api-Key') === ['key-test'];
        });
    }

    public function test_endpoint_placeholders_are_url_encoded(): void
    {
        $client = app(ApiClient::class);

        config(['quran.api.endpoints.collection' => 'collections/{slug}']);

        $this->assertSame(
            'collections/ratib-al-haddad',
            $client->endpoint('collection', ['slug' => 'ratib-al-haddad'])
        );
    }
}
