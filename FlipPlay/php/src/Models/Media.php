<?php

declare(strict_types=1);

namespace App\Models;

abstract class Media
{
    private static int $idCounter = 0;

    protected int $id;
    protected string $title;
    protected string $creator;
    protected int $year;

    public function __construct(
        string $title,
        string $creator,
        int $year
    ) {
        $this->id = ++self::$idCounter;
        $this->title = $title;
        $this->creator = $creator;
        $this->year = $year;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    abstract public function getCategory(): string;

    abstract public function getDetail(): string;
}