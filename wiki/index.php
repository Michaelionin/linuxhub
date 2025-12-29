<?php
// Конфигурация
$articles_dir = 'articles'; // Папка со статьями
$allowed_ext = ['html', 'php']; // Разрешенные расширения

// Получаем список статей
$articles = [];
if (is_dir($articles_dir)) {
    $files = scandir($articles_dir);
    foreach ($files as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_ext)) {
            $article_path = "$articles_dir/$file";
            
            // Извлекаем заголовок из файла
            $title = get_title_from_file($article_path);
            
            $articles[] = [
                'path' => $article_path,
                'title' => $title ?: $file
            ];
        }
    }
}

// Функция для извлечения заголовка из файла
function get_title_from_file($path) {
    $content = file_get_contents($path);
    
    // Поиск тега <title> через регулярное выражение
    if (preg_match('/<title>(.*?)<\/title>/is', $content, $matches)) {
        return htmlspecialchars_decode(trim($matches[1]));
    }
    
    // Альтернативный способ через DOM
    $dom = new DOMDocument();
    @$dom->loadHTML($content); // @ подавляет warnings
    $title_element = $dom->getElementsByTagName('title')->item(0);
    
    return $title_element ? trim($title_element->nodeValue) : null;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Linux Wiki - Главная</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .article-list {
            list-style: none;
            padding: 0;
        }
        .article-item {
            margin: 10px 0;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Linux Wiki</h1>
    
    <?php if (!empty($articles)): ?>
        <h2>Все статьи:</h2>
        <ul class="article-list">
            <?php foreach ($articles as $article): ?>
                <li class="article-item">
                    <a href="<?= htmlspecialchars($article['path']) ?>">
                        <?= htmlspecialchars($article['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Статьи не найдены</p>
    <?php endif; ?>
    
    <footer>
        <p>Сгенерировано автоматически <?= date('Y-m-d H:i:s') ?></p>
    </footer>
</body>
</html>
