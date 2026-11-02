<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Media (abstract)
 * Merepresentasikan item media dasar yang bisa dipinjam.
 */
abstract class Media
{
    // Property untuk ID media, diincrement secara otomatis
    private static int $idCounter = 0;
    private int $id;

    // Property yang bisa diakses oleh class turunan
    protected string $title;
    protected string $creator;
    protected int $year;

    // Status ketersediaan media
    private bool $available = true;

    /**
     * Constructor untuk class Media.
     * @param string $title Judul media
     * @param string $creator Pembuat media (sutradara/artis)
     * @param int $year Tahun rilis
     */
    public function __construct(string $title, string $creator, int $year)
    {
        $this->id = ++self::$idCounter; // Auto-increment ID
        $this->title = $title;
        $this->creator = $creator;
        $this->year = $year;
    }

    /**
     * Mengembalikan ID unik media.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Mengembalikan judul media.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Memeriksa apakah media tersedia untuk dipinjam.
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * Mengubah status media menjadi tidak tersedia (dipinjam).
     * @return void
     */
    public function borrow(): void
    {
        $this->available = false;
    }

    /**
     * Mengubah status media menjadi tersedia (dikembalikan).
     * @return void
     */
    public function giveBack(): void
    {
        $this->available = true;
    }

    /**
     * Method abstrak untuk mendapatkan tipe media (Film/Musik).
     * Akan di-override oleh class turunan.
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Mengembalikan detail dasar media.
     * Ini adalah bagian dari polymorphism, dimana class turunan akan meng-override atau memperluas method ini.
     * @return string
     */
    public function getDetail(): string
    {
        return "ID: {$this->id}, Judul: {$this->title}, Pembuat: {$this->creator}, Tahun: {$this->year}, Status: " . ($this->available ? "Tersedia" : "Dipinjam");
    }
}
