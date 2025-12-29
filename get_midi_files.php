<?php
header('Content-Type: application/json');

$midiDir = __DIR__ . '/midi';
$allowedExtensions = ['mid', 'midi'];
$files = [];

if (is_dir($midiDir)) {
    foreach (scandir($midiDir) as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $allowedExtensions)) {
            $files[] = $file;
        }
    }
}

// Сортируем файлы по имени
sort($files);

echo json_encode($files);
?>