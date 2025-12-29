<?php
header('Content-Type: application/json');

// Путь к локальной директории с MIDI-файлами
$directory = 'midi';

// Получаем список файлов
$files = scandir($directory);

// Фильтруем только MIDI-файлы
$midiFiles = array_filter($files, function ($file) use ($directory) {
    $path = $directory . '/' . $file;
    return is_file($path) && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['mid', 'midi']);
});

// Формируем правильные URL-адреса файлов
$baseUrl = 'https://linux.mypressonline.com/chat/midi/';
$fileUrls = array_map(fn($file) => $baseUrl . urlencode($file), $midiFiles);

// Возвращаем JSON
echo json_encode(array_values($fileUrls));
?>