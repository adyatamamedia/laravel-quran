<?php

namespace Adyatama\Quran\Controllers;

use Illuminate\Routing\Controller;
use Adyatama\Quran\Contracts\ContentServiceInterface;
use Adyatama\Quran\Contracts\QuranServiceInterface;
use Adyatama\Quran\Support\SurahSlug;
use Illuminate\Http\Request;

class TahlilController extends Controller
{
    protected QuranServiceInterface $quranService;
    protected ContentServiceInterface $contentService;

    public function __construct(QuranServiceInterface $quranService, ContentServiceInterface $contentService)
    {
        $this->quranService = $quranService;
        $this->contentService = $contentService;
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'tahlil');
        if (!in_array($tab, ['tahlil', 'yasin'], true)) {
            $tab = 'tahlil';
        }

        // Fetch Surah Yasin (Surah 36)
        $yasinSurah = $this->quranService->getSurah(36);

        $tahlilData = $this->contentService->getTahlil();

        $allSurahs = SurahSlug::all();

        return view('quran::tahlil-yasin', [
            'tab' => $tab,
            'yasinSurah' => $yasinSurah,
            'tahlilData' => $tahlilData,
            'allSurahs' => $allSurahs,
        ]);
    }
}
