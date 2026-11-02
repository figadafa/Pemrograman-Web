<?php

declare(strict_types=1);

/**
 * Autoloader sederhana untuk memetakan namespace App ke folder src/
 */
spl_autoload_register(function ($class) {
    // Prefix namespace yang kita gunakan
    $prefix = 'App\\';
    // Base directory untuk prefix namespace
    $base_dir = __DIR__ . '/src/';

    // Apakah class menggunakan prefix namespace?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Jika tidak, biarkan autoloader lain (jika ada) yang menangani
        return;
    }

    // Ambil relative class name
    $relative_class = substr($class, $len);

    // Ganti pemisah namespace dengan pemisah direktori, tambahkan akhiran .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Jika file ada, require
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\Movie;
use App\Models\Music;
use App\Models\User;
use App\Services\Library;

// Inisialisasi Library
$library = new Library();

echo "=== 1. MENAMBAHKAN MEDIA KE LIBRARY ===\n";
$library->add(new Movie("Inception", "Christopher Nolan", 2010, 148, "Sci-Fi"));
$library->add(new Movie("The Dark Knight", "Christopher Nolan", 2008, 152, "Action"));
$library->add(new Music("Bohemian Rhapsody", "Queen", 1975, "A Night at the Opera"));
$library->add(new Music("Shape of You", "Ed Sheeran", 2017, "Divide"));
echo "Berhasil menambahkan 2 Film dan 2 Musik ke perpustakaan.\n\n";

echo "=== 2. DAFTAR SEMUA MEDIA ===\n";
foreach ($library->listAll() as $item) {
    echo "[{$item->getType()}] {$item->getDetail()}\n";
}
echo "\n";

echo "=== 3. PENCARIAN MEDIA BERDASARKAN JUDUL ===\n";
$keyword = "Knight";
echo "Mencari dengan kata kunci: '{$keyword}'...\n";
$searchResults = $library->findByTitle($keyword);

if (empty($searchResults)) {
    echo "Media tidak ditemukan.\n";
} else {
    foreach ($searchResults as $result) {
        echo "Ditemukan: [{$result->getType()}] {$result->getTitle()}\n";
    }
}
echo "\n";

echo "=== 4. DETAIL SATU MEDIA ===\n";
$mediaId = 3;
$media = $library->findById($mediaId);
if ($media) {
    echo "Detail Media ID {$mediaId}:\n";
    echo $media->getDetail() . "\n";
}
echo "\n";

echo "=== 5. USER MEMINJAM MEDIA ===\n";
$user = new User("Budi");
echo "User '{$user->getName()}' meminjam 'Inception' (ID 1) dan 'Bohemian Rhapsody' (ID 3)...\n";

$library->borrow(1, $user);
$library->borrow(3, $user);

echo "Koleksi '{$user->getName()}' sekarang:\n";
foreach ($user->getCollection() as $item) {
    echo "- [{$item->getType()}] {$item->getTitle()}\n";
}
echo "\n";

echo "=== 6. MENGEMBALIKAN MEDIA ===\n";
echo "User '{$user->getName()}' mengembalikan 'Inception' (ID 1)...\n";
$library->returnMedia(1, $user);

echo "Koleksi '{$user->getName()}' yang tersisa:\n";
$remainingCollection = $user->getCollection();
if (empty($remainingCollection)) {
    echo "(Kosong)\n";
} else {
    foreach ($remainingCollection as $item) {
        echo "- [{$item->getType()}] {$item->getTitle()}\n";
    }
}
echo "\n";
echo "Status media ID 1 di library: " . ($library->findById(1)->isAvailable() ? "Tersedia" : "Dipinjam") . "\n";
