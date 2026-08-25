<?php

namespace Adyatama\Quran\Controllers;

use Illuminate\Routing\Controller;
use Adyatama\Quran\Contracts\ContentServiceInterface;
use Illuminate\Http\Request;

class MaulidController extends Controller
{
    protected ContentServiceInterface $contentService;

    public function __construct(ContentServiceInterface $contentService)
    {
        $this->contentService = $contentService;
    }

    public function index(Request $request)
    {
        $rawSlug = trim((string) $request->query('koleksi', ''));
        $slug = preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $rawSlug) === 1 ? $rawSlug : '';

        $allCollections = $this->contentService->getCollections();

        // Only collections whose name starts with "Maulid"
        $maulidCollections = array_values(array_filter($allCollections, function ($item) {
            $name = $item['name'] ?? '';
            return stripos($name, 'Maulid') === 0;
        }));

        $activeCollection = null;

        if (!empty($slug)) {
            $activeCollection = $this->contentService->getCollection($slug, 'maulid');
        }

        return view('quran::maulid', [
            'maulidCollections' => $maulidCollections,
            'activeCollection'  => $activeCollection,
            'slug'              => $slug,
        ]);
    }
}
