<?php

declare(strict_types=1);

namespace App\Models;

class Anime extends VideoContent
{
    private string $studio;

    public function __construct(
        string $title,
        string $creator,
        int $year,
        int $durationMinutes,
        string $studio
    ) {
        parent::__construct(
            $title,
            $creator,
            $year,
            $durationMinutes
        );

        $this->studio = $studio;
    }

    public function getCategory(): string
    {
        return "Anime";
    }

    public function getDetail(): string
    {
        return parent::getDetail() . ", Studio: {$this->studio}";
    }
}