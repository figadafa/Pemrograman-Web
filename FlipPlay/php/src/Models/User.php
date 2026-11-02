<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class User
 * Merepresentasikan pengguna perpustakaan media.
 */
class User
{
    // Nama pengguna
    private string $name;

    // Daftar koleksi media yang dipinjam oleh pengguna
    private array $collection = [];

    /**
     * Constructor untuk class User.
     * @param string $name Nama pengguna
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Mengembalikan nama pengguna.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Menambahkan media ke dalam koleksi pengguna.
     * @param Media $media Media yang dipinjam
     * @return void
     */
    public function addToCollection(Media $media): void
    {
        $this->collection[$media->getId()] = $media;
    }

    /**
     * Menghapus media dari koleksi pengguna.
     * @param int $mediaId ID media yang dikembalikan
     * @return void
     */
    public function removeFromCollection(int $mediaId): void
    {
        if (isset($this->collection[$mediaId])) {
            unset($this->collection[$mediaId]);
        }
    }

    /**
     * Mengembalikan seluruh koleksi media yang dipinjam oleh pengguna.
     * @return Media[]
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
