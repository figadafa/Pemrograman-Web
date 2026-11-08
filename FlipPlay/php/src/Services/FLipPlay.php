<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media;
use App\Models\User;

class FlipPlay
{
    private array $catalog = [];

    public function addContent(Media $media): void
    {
        $this->catalog[$media->getId()] = $media;
    }

    public function getAllContent(): array
    {
        return $this->catalog;
    }

    public function findByTitle(string $keyword): array
    {
        $results = [];

        foreach ($this->catalog as $media) {
            if (str_contains(
                strtolower($media->getTitle()),
                strtolower($keyword)
            )) {
                $results[] = $media;
            }
        }

        return $results;
    }

    public function findById(int $id): ?Media
    {
        return $this->catalog[$id] ?? null;
    }

    public function getByCategory(string $category): array
    {
        $results = [];

        foreach ($this->catalog as $media) {
            if (strcasecmp(
                $media->getCategory(),
                $category
            ) === 0) {
                $results[] = $media;
            }
        }

        return $results;
    }

    public function playContent(int $id, User $user): bool
    {
        $media = $this->findById($id);

        if ($media === null) {
            return false;
        }

        $user->addToHistory($media);

        return true;
    }
}