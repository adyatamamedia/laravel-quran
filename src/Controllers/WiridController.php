<?php

namespace Adyatama\Adyatama\Quran\Controllers;

use App\Http\Controllers\Controller;
use Adyatama\Adyatama\Quran\Services\IslamiApi\ApiClient;
use Illuminate\Http\Request;

class WiridController extends Controller
{
    protected ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function index(Request $request, ?string $slug = null)
    {
        $tab = $request->query('tab', 'doa'); // 'doa', 'wirid', or 'maulid'
        $categorySlug = $slug ?? $request->query('kategori', '');
        $wiridSlug = $request->query('koleksi', '');
        $maulidSlug = $request->query('maulid', '');
        $search = $request->query('q', '');

        // 1. Fetch Doa Categories from ASWAJA API
        $doaCategoriesRaw = $this->apiClient->getRaw('kategori-doa');
        $doaCategories = $doaCategoriesRaw['data'] ?? [];

        // 2. Fetch all collections from ASWAJA API
        $collectionsRaw = $this->apiClient->getRaw('collections');
        $allCollections = $collectionsRaw['data'] ?? [];

        // Wirid: exclude Tahlil & anything starting with "Maulid"
        $wiridCollections = array_values(array_filter($allCollections, function ($item) {
            $name = $item['name'] ?? '';
            $itemSlug = $item['slug'] ?? '';
            return $itemSlug !== 'tahlil-lengkap' && stripos($name, 'Maulid') !== 0;
        }));

        // Maulid: only collections whose name starts with "Maulid"
        $maulidCollections = array_values(array_filter($allCollections, function ($item) {
            $name = $item['name'] ?? '';
            return stripos($name, 'Maulid') === 0;
        }));

        // Detail containers
        $activeDoaCategory = null;
        $doaItems = [];
        $activeWiridCollection = null;
        $activeMaulidCollection = null;

        if ($tab === 'doa') {
            if (!empty($categorySlug) || !empty($search)) {
                $params = ['per_page' => 50];

                if (!empty($categorySlug)) {
                    foreach ($doaCategories as $cat) {
                        if (($cat['slug'] ?? '') === $categorySlug) {
                            $activeDoaCategory = $cat;
                            break;
                        }
                    }
                    $params['category'] = $categorySlug;
                }

                if (!empty($search)) {
                    $params['search'] = $search;
                }

                // Fetch directly from the new /doa v1.8.0 endpoint (includes full arabic, latin, translation)
                $raw = $this->apiClient->getRaw('doa', $params);
                $doaItems = $raw['data'] ?? [];
            }
        } elseif ($tab === 'wirid') {
            if (!empty($wiridSlug)) {
                $detailRaw = $this->apiClient->getRaw("collections/{$wiridSlug}");
                $activeWiridCollection = $detailRaw['data'] ?? null;

                if (!empty($activeWiridCollection['sections'])) {
                    foreach ($activeWiridCollection['sections'] as &$sec) {
                        foreach ($sec['items'] as &$item) {
                            $st = $item['source_type'] ?? '';
                            if ($st === 'content' && !empty($item['content']['slug'])) {
                                $cSlug = $item['content']['slug'];
                                $vals = collect($item['content']['values'] ?? [])->pluck('value', 'field_key');
                                if (empty($vals->get('arabic_text')) && empty($vals->get('arabic')) && empty($item['content']['sections'])) {
                                    $cDetail = $this->apiClient->getRaw("contents/{$cSlug}");
                                    $cData = $cDetail['data'] ?? $cDetail ?? [];
                                    if (!empty($cData['sections'])) {
                                        $item['content']['sections'] = $cData['sections'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } elseif ($tab === 'maulid') {
            if (!empty($maulidSlug)) {
                $detailRaw = $this->apiClient->getRaw("collections/{$maulidSlug}");
                $activeMaulidCollection = $detailRaw['data'] ?? null;
            }
        }

        return view('quran::wirid-doa', [
            'tab'                   => $tab,
            'search'                => $search,
            'categorySlug'          => $categorySlug,
            'wiridSlug'             => $wiridSlug,
            'maulidSlug'            => $maulidSlug,
            'doaCategories'         => $doaCategories,
            'activeDoaCategory'     => $activeDoaCategory,
            'doaItems'              => $doaItems,
            'wiridCollections'      => $wiridCollections,
            'maulidCollections'     => $maulidCollections,
            'activeWiridCollection' => $activeWiridCollection,
            'activeMaulidCollection'=> $activeMaulidCollection,
        ]);
    }
}
