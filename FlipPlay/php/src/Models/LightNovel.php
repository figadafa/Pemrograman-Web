<?php

declare(strict_types=1);

namespace App\Models;

class LightNovel extends ReadingContent
{
    private int $totalVolumes;

    public function __construct(
        string $title,
        string $creator,
        int $year,
        int $totalChapters,
        int $totalVolumes
    ) {
        parent::__construct(
            $title,
            $creator,
            $year,
            $totalChapters
        );

        $this->totalVolumes = $totalVolumes;
    }

    public function getCategory(): string
    {
        return "Light Novel";
    }

    public function getDetail(): string
    {
        return parent::getDetail() . ", Volume: {$this->totalVolumes}";
    }
}