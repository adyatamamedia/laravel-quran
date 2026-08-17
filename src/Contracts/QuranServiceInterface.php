<?php

namespace Adyatama\Adyatama\Quran\Contracts;

interface QuranServiceInterface
{
    public function getSurahs(array $filters = []): array;
    public function getSurah(int $number, array $params = []): ?object;
    public function getVerse(int $surahNumber, int $verseNumber, array $params = []): ?object;
    public function search(string $query, array $filters = []): array;
    public function getTahlil(array $filters = []): array;
    public function getWirid(string $slug = null, array $filters = []): array;
    public function getMaulid(array $filters = []): array;
}
