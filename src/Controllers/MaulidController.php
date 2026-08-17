<?php

namespace Adyatama\Adyatama\Quran\Controllers;

use App\Http\Controllers\Controller;
use Adyatama\Adyatama\Quran\Services\IslamiApi\ApiClient;
use Illuminate\Http\Request;

class MaulidController extends Controller
{
    protected ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function index(Request $request)
    {
        $slug = $request->query('koleksi', '');

        // Fetch all collections from ASWAJA API
        $collectionsRaw = $this->apiClient->getRaw('collections');
        $allCollections = $collectionsRaw['data'] ?? [];

        // Only collections whose name starts with "Maulid"
        $maulidCollections = array_values(array_filter($allCollections, function ($item) {
            $name = $item['name'] ?? '';
            return stripos($name, 'Maulid') === 0;
        }));

        $activeCollection = null;

        if (!empty($slug)) {
            $detailRaw = $this->apiClient->getRaw("collections/{$slug}");
            $activeCollection = $detailRaw['data'] ?? null;
        }

        return view('quran::maulid', [
            'maulidCollections' => $maulidCollections,
            'activeCollection'  => $activeCollection,
            'slug'              => $slug,
        ]);
    }
}
