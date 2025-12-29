<?php
// Папка для хранения статей
$articlesDir = 'tocensore';

// Файл для хранения информации об авторах
$authorsFile = 'authors.txt';

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Проверяем, что файл был загружен
    if (isset($_FILES['article']) && $_FILES['article']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['article']['tmp_name'];
        $fileName = $_FILES['article']['name'];
        $fileSize = $_FILES['article']['size'];
        $fileType = $_FILES['article']['type'];
        
        // Проверяем расширение файла
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Разрешенные расширения
        $allowedExtensions = ['txt', 'md'];
        
        if (!in_array($fileExt, $allowedExtensions)) {
            die('Ошибка: принимаются только файлы с расширениями .txt или .md');
        }
        
        // Генерируем уникальное имя файла с сохранением оригинального расширения
        $newFileName = uniqid('article_', true) . '.' . $fileExt;
        $destPath = $articlesDir . '/' . $newFileName;
        
        // Проверяем, существует ли папка для статей
        if (!is_dir($articlesDir)) {
            mkdir($articlesDir, 0755, true);
        }
        
        // Перемещаем загруженный файл
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Записываем информацию об авторе
            $authorInfo = date('Y-m-d H:i:s') . " | $newFileName | $nickname | $email | $ip\n";
            file_put_contents($authorsFile, $authorInfo, FILE_APPEND);
            
            // Перенаправляем с сообщением об успехе
            header('Location: prislatstatiy.html?status=success');
            exit;
        } else {
            die('Ошибка при загрузке файла');
        }
    } else {
        die('Ошибка: файл не был загружен');
    }
} else {
    die('Неверный метод запроса');
}
?>