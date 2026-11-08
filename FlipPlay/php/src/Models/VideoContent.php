<?php

declare(strict_types=1);

namespace App\Models;

abstract class VideoContent extends Media
{
    protected int $durationMinutes;

    public function __construct(
        string $title,
        string $creator,
        int $year,
        int $durationMinutes
    ) {
        parent::__construct($title, $creator, $year);
        $this->durationMinutes = $durationMinutes;
    }

    public function getDetail(): string
    {
        return "ID: {$this->id}, Judul: {$this->title}, 
        Creator: {$this->creator}, Tahun: {$this->year}, 
        Durasi: {$this->durationMinutes} menit";
    }
}