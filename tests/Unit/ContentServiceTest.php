<?php

namespace Adyatama\Quran\Tests\Unit;

use Adyatama\Quran\Services\IslamiApi\ContentService;
use Adyatama\Quran\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ContentServiceTest extends TestCase
{
    public function test_invalid_collection_slug_does_not_call_api(): void
    {
        Http::fake();

        $service = app(ContentService::class);

        $this->assertNull($service->getCollection('../private'));
        Http::assertNothingSent();
    }
}
