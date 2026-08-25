<?php

namespace Adyatama\Quran\Support;

class QuranCacheKeys
{
    public const SURAHS = 'quran:surahs:v1';
    public const SURAHS_STALE = 'quran:surahs:stale:v1';

    public static function surahs(array $params = []): string
    {
        return self::withParams(self::SURAHS, $params);
    }

    public static function surahsStale(array $params = []): string
    {
        return self::withParams(self::SURAHS_STALE, $params);
    }

    public static function surah(int $number, array $params = []): string
    {
        return self::withParams("quran:surah:{$number}:v1", $params);
    }

    public static function surahStale(int $number, array $params = []): string
    {
        return self::withParams("quran:surah:{$number}:stale:v1", $params);
    }

    public static function verse(int $surah, int $ayah, array $params = []): string
    {
        return self::withParams("quran:verse:{$surah}:{$ayah}:v1", $params);
    }

    public static function verseStale(int $surah, int $ayah, array $params = []): string
    {
        return self::withParams("quran:verse:{$surah}:{$ayah}:stale:v1", $params);
    }

    protected static function withParams(string $key, array $params): string
    {
        if ($params === []) {
            return $key;
        }

        ksort($params);

        return $key . ':' . sha1((string) json_encode($params));
    }
}
