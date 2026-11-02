<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media;
use App\Models\User;

/**
 * Class Library
 * Bertanggung jawab untuk mengelola daftar media dan proses peminjaman/pengembalian.
 */
class Library
{
    /**
     * @var array<int, Media> Daftar media dalam perpustakaan, diindeks berdasarkan ID.
     */
    private array $items = [];

    /**
     * Menambahkan media baru ke dalam daftar perpustakaan.
     * @param Media $media Objek media (Film atau Musik)
     * @return void
     */
    public function add(Media $media): void
    {
        $this->items[$media->getId()] = $media;
    }

    /**
     * Menampilkan semua media dalam perpustakaan.
     * @return Media[]
     */
    public function listAll(): array
    {
        return $this->items;
    }

    /**
     * Mencari media berdasarkan judul (case-insensitive).
     * @param string $keyword Kata kunci pencarian
     * @return Media[]
     */
    public function findByTitle(string $keyword): array
    {
        $results = [];
        $keyword = strtolower($keyword);
        
        foreach ($this->items as $item) {
            if (str_contains(strtolower($item->getTitle()), $keyword)) {
                $results[] = $item;
            }
        }
        
        return $results;
    }

    /**
     * Mencari media berdasarkan ID.
     * @param int $id ID media
     * @return Media|null Mengembalikan objek media atau null jika tidak ditemukan
     */
    public function findById(int $id): ?Media
    {
        return $this->items[$id] ?? null;
    }

    /**
     * Proses peminjaman media oleh user.
     * @param int $id ID media yang ingin dipinjam
     * @param User $user Objek user yang meminjam
     * @return bool True jika berhasil dipinjam, false jika tidak
     */
    public function borrow(int $id, User $user): bool
    {
        $media = $this->findById($id);

        // Validasi: media harus ada dan harus berstatus tersedia
        if ($media === null || !$media->isAvailable()) {
            return false;
        }

        // Update status media dan tambahkan ke koleksi user
        $media->borrow();
        $user->addToCollection($media);
        
        return true;
    }

    /**
     * Proses pengembalian media oleh user.
     * @param int $id ID media yang dikembalikan
     * @param User $user Objek user yang mengembalikan
     * @return bool True jika berhasil dikembalikan, false jika tidak
     */
    public function returnMedia(int $id, User $user): bool
    {
        $media = $this->findById($id);
        
        // Cek apakah media ada dalam koleksi user
        $userCollection = $user->getCollection();

        if ($media === null || !isset($userCollection[$id])) {
            return false;
        }

        // Update status media dan hapus dari koleksi user
        $media->giveBack();
        $user->removeFromCollection($id);

        return true;
    }
}
