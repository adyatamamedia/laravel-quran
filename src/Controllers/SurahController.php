<?php

namespace Adyatama\Adyatama\Quran\Controllers;

use App\Http\Controllers\Controller;
use Adyatama\Adyatama\Quran\Services\IslamiApi\QuranService;
use Adyatama\Adyatama\Quran\Support\SurahSlug;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    protected QuranService $quranService;

    public function __construct(QuranService $quranService)
    {
        $this->quranService = $quranService;
    }

    public function show(Request $request, string $surahSlug)
    {
        if (is_numeric($surahSlug)) {
            $num = (int) $surahSlug;
            $meta = SurahSlug::findByNumber($num);
            if ($meta) {
                return redirect()->route('quran.surah.show', ['surahSlug' => $meta['slug']], 301);
            }
        }

        $surahMeta = SurahSlug::findBySlug($surahSlug);
        if (!$surahMeta) {
            abort(404, 'Surah tidak ditemukan');
        }

        $surah = $this->quranService->getSurah($surahMeta['number']);

        if (!$surah) {
            abort(404, 'Data surah belum tersedia.');
        }

        $prevSurah = $surah->number > 1 ? SurahSlug::findByNumber($surah->number - 1) : null;
        $nextSurah = $surah->number < 114 ? SurahSlug::findByNumber($surah->number + 1) : null;
        $allSurahs = SurahSlug::all();

        return view('quran::show', [
            'surah' => $surah,
            'prevSurah' => $prevSurah,
            'nextSurah' => $nextSurah,
            'allSurahs' => $allSurahs,
            'targetAyah' => null,
        ]);
    }
}
