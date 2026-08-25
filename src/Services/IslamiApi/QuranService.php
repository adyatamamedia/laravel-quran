<?php

namespace Adyatama\Quran\Services\IslamiApi;

use Adyatama\Quran\Contracts\QuranServiceInterface;
use Adyatama\Quran\Data\SurahData;
use Adyatama\Quran\Data\VerseData;
use Adyatama\Quran\Support\QuranCacheKeys;
use Adyatama\Quran\Support\SurahSlug;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuranService implements QuranServiceInterface
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get all surahs, optionally filtered by API-supported parameters.
     *
     * @return SurahData[]
     */
    public function getSurahs(array $filters = []): array
    {
        $filters = $this->withoutNullValues($filters);
        $cacheParams = $this->cacheParams($filters);
        $useCache = (bool) config('quran.api.cache_enabled', true);
        $cacheKey = QuranCacheKeys::surahs($cacheParams);
        $staleKey = QuranCacheKeys::surahsStale($cacheParams);
        $ttl = (int) config('quran.api.cache_ttl.surahs', 604800);

        if ($useCache && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) {
                return array_map(fn ($s) => $s instanceof SurahData ? $s : new SurahData($s), $cached);
            }
        }

        $allRaw = [];
        $page = 1;

        do {
            $requestParams = array_merge($filters, ['page' => $page]);
            $raw = $this->client->getRaw($this->client->endpoint('surahs'), $requestParams);
            if (empty($raw) || !is_array($raw)) {
                break;
            }

            $items = $raw['data'] ?? [];
            if (empty($items) || !is_array($items)) {
                break;
            }

            $allRaw = array_merge($allRaw, $items);
            $hasMore = !empty($raw['links']['next']);
            $page++;
        } while ($hasMore && $page <= 10);

        if (!empty($allRaw)) {
            $surahs = array_map(fn ($item) => new SurahData($item), $allRaw);
            if ($useCache) {
                $payload = array_map(fn (SurahData $s) => $s->toArray(), $surahs);
                Cache::put($cacheKey, $payload, $ttl);
                Cache::put($staleKey, $payload, $ttl * 4);
            }

            return $surahs;
        }

        if ($useCache && Cache::has($staleKey)) {
            Log::info('Using stale cache for surah list', ['filters' => $filters]);
            $stale = Cache::get($staleKey);
            return is_array($stale)
                ? array_map(fn ($s) => new SurahData($s), $stale)
                : [];
        }

        Log::warning('Fallback to static SurahSlug map for surah list', ['filters' => $filters]);
        $fallback = [];
        foreach (SurahSlug::all() as $number => $item) {
            $fallback[] = new SurahData(array_merge(['number' => $number], $item));
        }

        return $fallback;
    }

    /**
     * Get a single surah with verses by number or slug.
     */
    public function getSurah(int|string $identifier, array $params = []): ?SurahData
    {
        $number = $this->resolveSurahNumber($identifier);
        if ($number === null) {
            return null;
        }

        $requestParams = array_merge([
            'include' => 'translations,tafsirs',
        ], $params);
        $cacheParams = $this->cacheParams($requestParams);
        $useCache = (bool) config('quran.api.cache_enabled', true);
        $cacheKey = QuranCacheKeys::surah($number, $cacheParams);
        $staleKey = QuranCacheKeys::surahStale($number, $cacheParams);
        $ttl = (int) config('quran.api.cache_ttl.surah', 604800);

        if ($useCache && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) || $cached instanceof SurahData) {
                return $cached instanceof SurahData ? $cached : new SurahData($cached);
            }
        }

        $raw = $this->client->get(
            $this->client->endpoint('surah', ['number' => $number]),
            $requestParams
        );

        if (!empty($raw) && is_array($raw)) {
            $surahData = new SurahData($raw);
            if ($useCache) {
                $payload = $surahData->toArray();
                Cache::put($cacheKey, $payload, $ttl);
                Cache::put($staleKey, $payload, $ttl * 4);
            }

            return $surahData;
        }

        if ($useCache && Cache::has($staleKey)) {
            Log::info("Using stale cache for surah {$number}");
            $stale = Cache::get($staleKey);
            return is_array($stale) ? new SurahData($stale) : null;
        }

        $meta = SurahSlug::findByNumber($number);
        return $meta ? new SurahData(array_merge(['number' => $number], $meta)) : null;
    }

    /**
     * Get a single verse by surah number/slug and ayah number.
     */
    public function getVerse(int|string $surahNumber, int $ayahNumber, array $params = []): ?VerseData
    {
        $number = $this->resolveSurahNumber($surahNumber);
        if ($number === null || $ayahNumber < 1) {
            return null;
        }

        $requestParams = array_merge([
            'include' => 'translations,tafsirs',
        ], $params);
        $cacheParams = $this->cacheParams($requestParams);
        $useCache = (bool) config('quran.api.cache_enabled', true);
        $cacheKey = QuranCacheKeys::verse($number, $ayahNumber, $cacheParams);
        $staleKey = QuranCacheKeys::verseStale($number, $ayahNumber, $cacheParams);
        $ttl = (int) config('quran.api.cache_ttl.verse', 604800);

        if ($useCache && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) || $cached instanceof VerseData) {
                return $cached instanceof VerseData ? $cached : new VerseData($cached, $number);
            }
        }

        $surah = $this->getSurah($number);
        if ($surah && $surah->versesCount > 0 && $ayahNumber > $surah->versesCount) {
            return null;
        }

        if ($surah && !empty($surah->verses)) {
            foreach ($surah->verses as $verse) {
                if ($verse->ayahNumber === $ayahNumber) {
                    return $verse;
                }
            }
        }

        $raw = $this->client->get(
            $this->client->endpoint('verse', ['surah' => $number, 'ayah' => $ayahNumber]),
            $requestParams
        );

        if (empty($raw)) {
            $raw = $this->client->get(
                $this->client->endpoint('verse_legacy', ['surah' => $number, 'ayah' => $ayahNumber]),
                $requestParams
            );
        }

        if (!empty($raw) && is_array($raw)) {
            $verse = new VerseData($raw, $number);
            if ($useCache) {
                $payload = $verse->toArray();
                Cache::put($cacheKey, $payload, $ttl);
                Cache::put($staleKey, $payload, $ttl * 4);
            }

            return $verse;
        }

        if ($useCache && Cache::has($staleKey)) {
            $stale = Cache::get($staleKey);
            return is_array($stale) ? new VerseData($stale, $number) : null;
        }

        return null;
    }

    /**
     * Search surah metadata by keyword or number.
     *
     * @return SurahData[]
     */
    public function searchSurah(string $query, array $filters = []): array
    {
        $normalizedQuery = $this->normalizeSearchValue($query);
        if ($normalizedQuery === '') {
            return [];
        }

        $results = [];
        foreach ($this->getSurahs($filters) as $surah) {
            if (is_numeric(trim($query)) && (int) $query === $surah->number) {
                $results[] = $surah;
                continue;
            }

            $searchable = [
                $this->normalizeSearchValue($surah->nameLatin),
                $this->normalizeSearchValue($surah->translatedName),
                $this->normalizeSearchValue($surah->slug),
            ];

            foreach ($searchable as $value) {
                if (str_contains($value, $normalizedQuery)) {
                    $results[] = $surah;
                    break;
                }
            }
        }

        return $results;
    }

    protected function resolveSurahNumber(int|string $identifier): ?int
    {
        $number = is_numeric($identifier)
            ? (int) $identifier
            : SurahSlug::getNumber((string) $identifier);

        return $number >= 1 && $number <= 114 ? $number : null;
    }

    protected function cacheParams(array $params): array
    {
        return $this->withoutNullValues(array_merge(
            (array) config('quran.api.default_query', []),
            $params
        ));
    }

    protected function normalizeSearchValue(string $value): string
    {
        $ascii = Str::ascii(mb_strtolower($value, 'UTF-8'));
        return preg_replace('/[^a-z0-9]/', '', $ascii) ?? '';
    }

    protected function withoutNullValues(array $values): array
    {
        return array_filter($values, static fn ($value) => $value !== null && $value !== '');
    }
}
