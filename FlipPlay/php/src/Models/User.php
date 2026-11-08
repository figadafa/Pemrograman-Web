<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    private string $name;
    private array $history = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addToHistory(Media $media): void
    {
        $this->history[] = $media;
    }

    public function getHistory(): array
    {
        return $this->history;
    }
}