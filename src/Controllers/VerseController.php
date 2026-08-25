<?php

namespace Adyatama\Quran\Controllers;

use Illuminate\Routing\Controller;
use Adyatama\Quran\Contracts\QuranServiceInterface;
use Adyatama\Quran\Support\SurahSlug;
use Illuminate\Http\Request;

class VerseController extends Controller
{
    protected QuranServiceInterface $quranService;

    public function __construct(QuranServiceInterface $quranService)
    {
        $this->quranService = $quranService;
    }

    public function show(Request $request, string $surahSlug, int|string $ayah)
    {
        $ayahNumber = (int) $ayah;

        $surahMeta = SurahSlug::findBySlug($surahSlug);
        if (!$surahMeta) {
            abort(404, 'Surah tidak ditemukan');
        }

        if ($ayahNumber < 1 || $ayahNumber > $surahMeta['count']) {
            abort(404, 'Ayat tidak ditemukan');
        }

        $surah = $this->quranService->getSurah($surahMeta['number']);
        if (!$surah) {
            abort(404, 'Data surah belum tersedia.');
        }

        if ($surah->versesCount > 0 && empty($surah->verses)) {
            abort(503, 'Data ayat sedang tidak tersedia. Silakan coba lagi nanti.');
        }

        $prevSurah = $surah->number > 1 ? SurahSlug::findByNumber($surah->number - 1) : null;
        $nextSurah = $surah->number < 114 ? SurahSlug::findByNumber($surah->number + 1) : null;
        $allSurahs = SurahSlug::all();

        return view('quran::show', [
            'surah' => $surah,
            'prevSurah' => $prevSurah,
            'nextSurah' => $nextSurah,
            'allSurahs' => $allSurahs,
            'targetAyah' => $ayahNumber,
        ]);
    }
}
