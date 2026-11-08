<?php

declare(strict_types=1);

namespace App\Models;

abstract class ReadingContent extends Media
{
    protected int $totalChapters;

    public function __construct(
        string $title,
        string $creator,
        int $year,
        int $totalChapters
    ) {
        parent::__construct($title, $creator, $year);
        $this->totalChapters = $totalChapters;
    }

    public function getDetail(): string
    {
        return "ID: {$this->id}, Judul: {$this->title}, 
        Creator: {$this->creator}, Tahun: {$this->year}, 
        Total Chapter: {$this->totalChapters}";
    }
}