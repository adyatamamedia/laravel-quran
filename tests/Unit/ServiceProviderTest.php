<?php

namespace Adyatama\Quran\Tests\Unit;

use Adyatama\Quran\Contracts\QuranServiceInterface;
use Adyatama\Quran\Data\SurahData;
use Adyatama\Quran\Data\VerseData;
use Adyatama\Quran\Services\IslamiApi\QuranService;
use Adyatama\Quran\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_custom_driver_is_resolved_through_the_interface(): void
    {
        config(['quran.service' => LocalQuranService::class]);
        app()->forgetInstance(QuranServiceInterface::class);

        $service = app(QuranServiceInterface::class);

        $this->assertInstanceOf(LocalQuranService::class, $service);
        $this->assertNotInstanceOf(QuranService::class, $service);
    }
}

class LocalQuranService implements QuranServiceInterface
{
    public function getSurahs(array $filters = []): array
    {
        return [];
    }

    public function getSurah(int|string $identifier, array $params = []): ?SurahData
    {
        return null;
    }

    public function getVerse(int|string $surahNumber, int $ayahNumber, array $params = []): ?VerseData
    {
        return null;
    }

    public function searchSurah(string $query, array $filters = []): array
    {
        return [];
    }
}
