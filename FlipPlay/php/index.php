<?php

declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';

    if (str_starts_with($class, $prefix)) {
        $relativeClass = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
});

use App\Models\Anime;
use App\Models\Drama;
use App\Models\Manga;
use App\Models\LightNovel;
use App\Models\User;
use App\Services\FlipPlay;

$flipPlay = new FlipPlay();

$flipPlay->addContent(
    new Anime("Attack on Titan", "Hajime Isayama", 2013, 24, "MAPPA")
);

$flipPlay->addContent(
    new Drama("Moving", "Kang Full", 2023, 60, "Korea Selatan")
);

$flipPlay->addContent(
    new Manga("One Piece", "Eiichiro Oda", 1997, 1100, "Adventure")
);

$flipPlay->addContent(
    new LightNovel("Overlord", "Kugane Maruyama", 2012, 100, 16)
);

echo "=== KATALOG FLIPPLAY ===\n";

foreach ($flipPlay->getAllContent() as $media) {
    echo $media->getCategory() . " - ";
    echo $media->getTitle() . "\n";
}

echo "\n=== PENCARIAN KONTEN ===\n";

$results = $flipPlay->findByTitle("One");

foreach ($results as $media) {
    echo $media->getTitle() . "\n";
}

echo "\n=== DETAIL KONTEN ===\n";

$media = $flipPlay->findById(1);

if ($media !== null) {
    echo $media->getDetail() . "\n";
}

echo "\n=== KONTEN KATEGORI MANGA ===\n";

foreach ($flipPlay->getByCategory("Manga") as $media) {
    echo $media->getTitle() . "\n";
}

$user = new User("Budi");

echo "\n=== SIMULASI MENONTON KONTEN ===\n";

if ($flipPlay->playContent(1, $user)) {
    echo $user->getName() . " memilih konten Attack on Titan\n";
}

echo "\n=== RIWAYAT PENGGUNA ===\n";

foreach ($user->getHistory() as $media) {
    echo $media->getTitle() . "\n";
}