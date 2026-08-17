<?php

namespace Adyatama\Quran\Contracts;

use Adyatama\Quran\Data\SurahData;
use Adyatama\Quran\Data\VerseData;

interface QuranServiceInterface
{
    /**
     * @param array $filters
     * @return SurahData[]
     */
    public function getSurahs(array $filters = []): array;

    public function getSurah(int|string $identifier, array $params = []): ?SurahData;

    public function getVerse(int|string $surahNumber, int $ayahNumber, array $params = []): ?VerseData;

    /**
     * @param string $query
     * @param array $filters
     * @return SurahData[]
     */
    public function searchSurah(string $query, array $filters = []): array;
}
