<?php

namespace Adyatama\Quran\Contracts;

interface ContentServiceInterface
{
    public function getDoaCategories(): array;

    public function getCollections(): array;

    public function getCollection(string $slug, string $type = 'collection'): ?array;

    public function getDoa(array $params = []): array;

    public function getContent(string $slug): ?array;

    public function getTahlil(): ?array;
}
