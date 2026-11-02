<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Movie
 * Mewarisi dari Media, merepresentasikan sebuah film.
 */
class Movie extends Media
{
    // Property spesifik untuk film
    private int $durationMinutes;
    private string $genre;

    /**
     * Constructor untuk class Movie.
     * Memanggil constructor parent (Media) dan menginisialisasi property spesifik film.
     * @param string $title Judul film
     * @param string $creator Sutradara film
     * @param int $year Tahun rilis
     * @param int $durationMinutes Durasi film dalam menit
     * @param string $genre Genre film
     */
    public function __construct(string $title, string $creator, int $year, int $durationMinutes, string $genre)
    {
        parent::__construct($title, $creator, $year); // Memanggil constructor dari class Media (inheritance)
        $this->durationMinutes = $durationMinutes;
        $this->genre = $genre;
    }

    /**
     * Mengembalikan tipe media sebagai 'Film'.
     * Meng-override method abstrak dari class Media.
     * @return string
     */
    public function getType(): string
    {
        return 'Film';
    }

    /**
     * Mengembalikan detail lengkap film, termasuk durasi dan genre.
     * Meng-override dan memperluas method getDetail dari class Media (polymorphism).
     * @return string
     */
    public function getDetail(): string
    {
        // Memanggil method getDetail dari parent untuk detail dasar, lalu menambahkan detail spesifik film.
        return parent::getDetail() . ", Durasi: {$this->durationMinutes} menit, Genre: {$this->genre}";
    }

    /**
     * Mengembalikan durasi film.
     * @return int
     */
    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }

    /**
     * Mengembalikan genre film.
     * @return string
     */
    public function getGenre(): string
    {
        return $this->genre;
    }
}
