<?php

namespace Adyatama\Quran\Services\IslamiApi;

use Adyatama\Quran\Contracts\ContentServiceInterface;

class ContentService implements ContentServiceInterface
{
    protected ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getDoaCategories(): array
    {
        return $this->data($this->client->getRaw($this->client->endpoint('categories_doa')));
    }

    public function getCollections(): array
    {
        return $this->data($this->client->getRaw($this->client->endpoint('collections')));
    }

    public function getCollection(string $slug, string $type = 'collection'): ?array
    {
        if (!$this->isValidSlug($slug)) {
            return null;
        }

        $endpointKey = in_array($type, ['wirid', 'maulid'], true) ? $type : 'collection';

        return $this->dataOrNull($this->client->getRaw(
            $this->client->endpoint($endpointKey, ['slug' => $slug])
        ));
    }

    public function getDoa(array $params = []): array
    {
        return $this->data($this->client->getRaw($this->client->endpoint('doa'), $params));
    }

    public function getContent(string $slug): ?array
    {
        if (!$this->isValidSlug($slug)) {
            return null;
        }

        return $this->dataOrNull($this->client->getRaw(
            $this->client->endpoint('content', ['slug' => $slug])
        ));
    }

    public function getTahlil(): ?array
    {
        return $this->dataOrNull($this->client->getRaw($this->client->endpoint('tahlil')));
    }

    protected function data(?array $response): array
    {
        $data = $response['data'] ?? [];
        return is_array($data) ? $data : [];
    }

    protected function dataOrNull(?array $response): ?array
    {
        $data = $response['data'] ?? null;
        return is_array($data) ? $data : null;
    }

    protected function isValidSlug(string $slug): bool
    {
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) === 1;
    }
}
