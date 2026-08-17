<?php

namespace Adyatama\Adyatama\Quran\Services\IslamiApi;

use Adyatama\Adyatama\Quran\Data\SurahData;
use Adyatama\Adyatama\Quran\Data\VerseData;
use Adyatama\Adyatama\Quran\Support\QuranCacheKeys;
use Adyatama\Adyatama\Quran\Support\SurahSlug;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use Adyatama\Adyatama\Quran\Contracts\QuranServiceInterface;

class QuranService implements QuranServiceInterface
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get all 114 surahs.
     * @return SurahData[]
     */
    public function getSurahs(): array
    {
        $useCache = (bool) config('quran.api.cache_enabled', true);
        $cacheKey = QuranCacheKeys::SURAHS;
        $staleKey = QuranCacheKeys::SURAHS_STALE;
        $ttl = config('quran.api.cache_ttl.surahs', 604800);

        if ($useCache && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) {
                return array_map(fn($s) => $s instanceof SurahData ? $s : new SurahData($s), $cached);
            }
        }

        // Fetch all 114 surahs (API paginates at 15/page → 8 pages total)
        $allRaw = [];
        $page = 1;
        do {
            $raw = $this->client->getRaw('quran/surahs', ['page' => $page]);
            if (empty($raw) || !is_array($raw)) break;

            $items = $raw['data'] ?? [];
            if (empty($items) || !is_array($items)) break;

            $allRaw = array_merge($allRaw, $items);
            $hasMore = !empty($raw['links']['next']);
            $page++;
        } while ($hasMore && $page <= 10); // safety cap at 10 pages

        if (!empty($allRaw)) {
            $surahs = array_map(fn($item) => new SurahData($item), $allRaw);
            if ($useCache) {
                Cache::put($cacheKey, array_map(fn(SurahData $s) => $s->toArray(), $surahs), $ttl);
                Cache::put($staleKey, array_map(fn(SurahData $s) => $s->toArray(), $surahs), $ttl * 4);
            }
            return $surahs;
        }

        // Try Stale Cache
        if ($useCache && Cache::has($staleKey)) {
            Log::info("Using stale cache for surah list");
            $stale = Cache::get($staleKey);
            return array_map(fn($s) => new SurahData($s), $stale);
        }

        // Fallback to static SurahSlug definition (ensures page never 500s)
        Log::warning("Fallback to static SurahSlug map for surah list");
        $fallback = [];
        foreach (SurahSlug::all() as $number => $item) {
            $fallback[] = new SurahData(array_merge(['number' => $number], $item));
        }
        return $fallback;
    }

    /**
     * Get single Surah with verses by Surah number or slug.
     */
    public function getSurah(int|string $identifier): ?SurahData
    {
        $number = is_numeric($identifier) ? (int) $identifier : SurahSlug::getNumber($identifier);

        if (!$number || $number < 1 || $number > 114) {
            return null;
        }

        $useCache = (bool) config('quran.api.cache_enabled', true);
        $cacheKey = QuranCacheKeys::surah($number);
        $staleKey = QuranCacheKeys::surahStale($number);
        $ttl = config('quran.api.cache_ttl.surah', 604800);

        if ($useCache && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached instanceof SurahData ? $cached : new SurahData($cached);
            }
        }

        // Correct endpoint: /api/v1/quran/surahs/{number}?include=translations,tafsirs
        $raw = $this->client->get("quran/surahs/{$number}", ['include' => 'translations,tafsirs']);

        if (!empty($raw) && is_array($raw)) {
            $surahData = new SurahData($raw);
            if ($useCache) {
                Cache::put($cacheKey, $surahData->toArray(), $ttl);
                Cache::put($staleKey, $surahData->toArray(), $ttl * 4);
            }
            return $surahData;
        }

        // Try Stale Cache
        if ($useCache && Cache::has($staleKey)) {
            Log::info("Using stale cache for surah {$number}");
            return new SurahData(Cache::get($staleKey));
        }

        // Static fallback for metadata if API is unreachable
        $meta = SurahSlug::findByNumber($number);
        if ($meta) {
            return new SurahData(array_merge(['number' => $number], $meta));
        }

        return null;
    }

    /**
     * Get single verse.
     */
    public function getVerse(int $surahNumber, int $ayahNumber): ?VerseData
    {
        $surah = $this->getSurah($surahNumber);
        if ($surah && !empty($surah->verses)) {
            foreach ($surah->verses as $verse) {
                if ($verse->ayahNumber === $ayahNumber) {
                    return $verse;
                }
            }
        }

        // Try direct API if surah didn't have verse
        $raw = $this->client->get("quran/surah/{$surahNumber}/ayah/{$ayahNumber}", ['include' => 'translations,tafsirs'])
            ?? $this->client->get("surah/{$surahNumber}/{$ayahNumber}", ['include' => 'translations,tafsirs']);

        if (!empty($raw) && is_array($raw)) {
            return new VerseData($raw, $surahNumber);
        }

        return null;
    }

    /**
     * Search Surahs by keyword or number.
     * @return SurahData[]
     */
    public function searchSurah(string $query): array
    {
        $query = trim(strtolower($query));
        if ($query === '') {
            return [];
        }

        $allSurahs = $this->getSurahs();
        $results = [];

        foreach ($allSurahs as $surah) {
            if (is_numeric($query) && (int)$query === $surah->number) {
                $results[] = $surah;
                continue;
            }

            $cleanQuery = preg_replace('/[^a-z0-9]/', '', $query);
            $cleanLatin = preg_replace('/[^a-z0-9]/', '', strtolower($surah->nameLatin));
            $cleanTrans = preg_replace('/[^a-z0-9]/', '', strtolower($surah->translatedName));

            if (
                str_contains($cleanLatin, $cleanQuery) || 
                str_contains($cleanTrans, $cleanQuery) || 
                str_contains(strtolower($surah->slug), $cleanQuery)
            ) {
                $results[] = $surah;
            }
        }

        return $results;
    }
}
