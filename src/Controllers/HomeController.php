<?php

namespace Adyatama\Quran\Controllers;

use Illuminate\Routing\Controller;
use Adyatama\Quran\Services\IslamiApi\QuranService;
use Adyatama\Quran\Support\SurahSlug;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected QuranService $quranService;

    public function __construct(QuranService $quranService)
    {
        $this->quranService = $quranService;
    }

    public function index(Request $request)
    {
        $surahs = $this->quranService->getSurahs();

        $popularSurahs = [
            ['name' => 'Yasin', 'slug' => 'yasin', 'number' => 36],
            ['name' => 'Al-Waqi\'ah', 'slug' => 'al-waqiah', 'number' => 56],
            ['name' => 'Al-Mulk', 'slug' => 'al-mulk', 'number' => 67],
            ['name' => 'Al-Kahf', 'slug' => 'al-kahf', 'number' => 18],
            ['name' => 'Ar-Rahman', 'slug' => 'ar-rahman', 'number' => 55],
            ['name' => 'Ayat Kursi', 'slug' => 'al-baqarah/255', 'number' => 2, 'isVerse' => true],
        ];

        return view('quran::index', [
            'surahs' => $surahs,
            'popularSurahs' => $popularSurahs,
        ]);
    }
}
