<?php

namespace Adyatama\Quran\Controllers;

use App\Http\Controllers\Controller;
use Adyatama\Quran\Services\IslamiApi\QuranService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected QuranService $quranService;

    public function __construct(QuranService $quranService)
    {
        $this->quranService = $quranService;
    }

    public function index(Request $request)
    {
        $query = (string) $request->input('q', '');
        $results = $this->quranService->searchSurah($query);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'query' => $query,
                'total' => count($results),
                'data' => array_map(fn($s) => $s->toArray(), $results),
            ]);
        }

        return view('quran::search', [
            'query' => $query,
            'results' => $results,
        ]);
    }
}
