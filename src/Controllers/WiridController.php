<?php

namespace Adyatama\Quran\Controllers;

use Illuminate\Routing\Controller;
use Adyatama\Quran\Contracts\ContentServiceInterface;
use Illuminate\Http\Request;

class WiridController extends Controller
{
    protected ContentServiceInterface $contentService;

    public function __construct(ContentServiceInterface $contentService)
    {
        $this->contentService = $contentService;
    }

    public function index(Request $request, ?string $slug = null)
    {
        $tab = $request->query('tab', 'doa');
        $tab = in_array($tab, ['doa', 'wirid', 'maulid'], true) ? $tab : 'doa';
        $categorySlug = $this->validSlug($slug ?? $request->query('kategori', ''));
        $wiridSlug = $this->validSlug($request->query('koleksi', ''));
        $maulidSlug = $this->validSlug($request->query('maulid', ''));
        $search = mb_substr(trim((string) $request->query('q', '')), 0, 100);

        $doaCategories = $this->contentService->getDoaCategories();

        $allCollections = $this->contentService->getCollections();

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

                $doaItems = $this->contentService->getDoa($params);
            }
        } elseif ($tab === 'wirid') {
            if (!empty($wiridSlug)) {
                $activeWiridCollection = $this->contentService->getCollection($wiridSlug, 'wirid');

                if (!empty($activeWiridCollection['sections'])) {
                    foreach ($activeWiridCollection['sections'] as &$sec) {
                        foreach ($sec['items'] as &$item) {
                            $st = $item['source_type'] ?? '';
                            if ($st === 'content' && !empty($item['content']['slug'])) {
                                $cSlug = $item['content']['slug'];
                                $vals = collect($item['content']['values'] ?? [])->pluck('value', 'field_key');
                                if (empty($vals->get('arabic_text')) && empty($vals->get('arabic')) && empty($item['content']['sections'])) {
                                    $cData = $this->contentService->getContent($cSlug) ?? [];
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
                $activeMaulidCollection = $this->contentService->getCollection($maulidSlug, 'maulid');
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

    protected function validSlug(mixed $value): string
    {
        $slug = trim((string) $value);
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) === 1 ? $slug : '';
    }
}
