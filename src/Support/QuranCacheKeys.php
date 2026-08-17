<?php

namespace Adyatama\Adyatama\Quran\Support;

class QuranCacheKeys
{
    public const SURAHS = 'quran:surahs:v1';
    public const SURAHS_STALE = 'quran:surahs:stale:v1';

    public static function surah(int $number): string
    {
        return "quran:surah:{$number}:v1";
    }

    public static function surahStale(int $number): string
    {
        return "quran:surah:{$number}:stale:v1";
    }

    public static function verse(int $surah, int $ayah): string
    {
        return "quran:verse:{$surah}:{$ayah}:v1";
    }

    public static function verseStale(int $surah, int $ayah): string
    {
        return "quran:verse:{$surah}:{$ayah}:stale:v1";
    }
}
