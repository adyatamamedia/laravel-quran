<?php

namespace Adyatama\Quran\Controllers;

use App\Http\Controllers\Controller;
use Adyatama\Quran\Services\IslamiApi\QuranService;
use Adyatama\Quran\Services\IslamiApi\ApiClient;
use Adyatama\Quran\Support\SurahSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TahlilController extends Controller
{
    protected QuranService $quranService;
    protected ApiClient $apiClient;

    public function __construct(QuranService $quranService, ApiClient $apiClient)
    {
        $this->quranService = $quranService;
        $this->apiClient = $apiClient;
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'tahlil');
        if (!in_array($tab, ['tahlil', 'yasin'], true)) {
            $tab = 'tahlil';
        }

        // Fetch Surah Yasin (Surah 36)
        $yasinSurah = $this->quranService->getSurah(36);

        // Fetch Tahlil Collection directly from ASWAJA API (Always fresh, no cache)
        $raw = $this->apiClient->getRaw('collections/tahlil-lengkap');
        $tahlilData = $raw['data'] ?? null;

        $allSurahs = SurahSlug::all();

        return view('quran::tahlil-yasin', [
            'tab' => $tab,
            'yasinSurah' => $yasinSurah,
            'tahlilData' => $tahlilData,
            'allSurahs' => $allSurahs,
        ]);
    }
}
