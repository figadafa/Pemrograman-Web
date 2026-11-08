<?php

declare(strict_types=1);

namespace App\Models;

class Drama extends VideoContent
{
    private string $country;

    public function __construct(
        string $title,
        string $creator,
        int $year,
        int $durationMinutes,
        string $country
    ) {
        parent::__construct(
            $title,
            $creator,
            $year,
            $durationMinutes
        );

        $this->country = $country;
    }

    public function getCategory(): string
    {
        return "Drama";
    }

    public function getDetail(): string
    {
        return parent::getDetail() . ", Negara: {$this->country}";
    }
}