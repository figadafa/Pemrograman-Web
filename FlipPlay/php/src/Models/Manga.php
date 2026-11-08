<?php

declare(strict_types=1);

namespace App\Models;

class Manga extends ReadingContent
{
    private string $genre;

    public function __construct(
        string $title,
        string $creator,
        int $year,
        int $totalChapters,
        string $genre
    ) {
        parent::__construct(
            $title,
            $creator,
            $year,
            $totalChapters
        );

        $this->genre = $genre;
    }

    public function getCategory(): string
    {
        return "Manga";
    }

    public function getDetail(): string
    {
        return parent::getDetail() . ", Genre: {$this->genre}";
    }
}