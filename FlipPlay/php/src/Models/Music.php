<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Music
 * Mewarisi dari Media, merepresentasikan sebuah musik/lagu.
 */
class Music extends Media
{
    // Property spesifik untuk musik
    private string $album;

    /**
     * Constructor untuk class Music.
     * Memanggil constructor parent (Media) dan menginisialisasi property spesifik musik.
     * @param string $title Judul lagu
     * @param string $creator Artis/Band
     * @param int $year Tahun rilis
     * @param string $album Nama album
     */
    public function __construct(string $title, string $creator, int $year, string $album)
    {
        parent::__construct($title, $creator, $year); // Memanggil constructor dari class Media (inheritance)
        $this->album = $album;
    }

    /**
     * Mengembalikan tipe media sebagai 'Musik'.
     * Meng-override method abstrak dari class Media.
     * @return string
     */
    public function getType(): string
    {
        return 'Musik';
    }

    /**
     * Mengembalikan detail lengkap musik, termasuk nama album.
     * Meng-override dan memperluas method getDetail dari class Media (polymorphism).
     * @return string
     */
    public function getDetail(): string
    {
        // Memanggil method getDetail dari parent untuk detail dasar, lalu menambahkan detail spesifik musik.
        return parent::getDetail() . ", Album: {$this->album}";
    }

    /**
     * Mengembalikan nama album.
     * @return string
     */
    public function getAlbum(): string
    {
        return $this->album;
    }
}
