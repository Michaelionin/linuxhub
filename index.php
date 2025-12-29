<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linux-hub</title>
    <style>
        body {
            background-color: #000;
            color: #0F0;
            font-family: 'Courier New', Courier, monospace;
            margin: 20px;
        }
        a {
            color: #0F0;
            text-decoration: underline;
        }
        a:hover {
            color: #FFF;
        }
        h1 {
            font-size: 24px;
            text-align: center;
        }
        hr {
            border: 1px solid #0F0;
        }
        .articles {
            margin-top: 20px;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        
        /* Стили для Markdown-читалки */
        .markdown-viewer {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .markdown-viewer h1, .markdown-viewer h2, .markdown-viewer h3 {
            color: #0F0;
            border-bottom: 1px solid #0F0;
            padding-bottom: 5px;
        }
        .markdown-viewer h1 { font-size: 1.8em; }
        .markdown-viewer h2 { font-size: 1.5em; }
        .markdown-viewer h3 { font-size: 1.2em; }
        .markdown-viewer p, .markdown-viewer li {
            line-height: 1.5;
        }
        .markdown-viewer code {
            background-color: #111;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .markdown-viewer pre {
            background-color: #111;
            padding: 10px;
            border-radius: 3px;
            overflow-x: auto;
        }
        .markdown-viewer blockquote {
            border-left: 3px solid #0F0;
            padding-left: 10px;
            margin-left: 0;
            color: #0A0;
        }
        .markdown-viewer table {
            border-collapse: collapse;
            width: 100%;
            margin: 15px 0;
        }
        .markdown-viewer table, .markdown-viewer th, .markdown-viewer td {
            border: 1px solid #0F0;
        }
        .markdown-viewer th, .markdown-viewer td {
            padding: 8px;
        }
        .markdown-viewer img {
            max-width: 100%;
        }
    </style>
</head>
<body>
     <img src= "http://linux.mypressonline.com/linuxhub.png">
    <br>
    <a href="http://linux.mypressonline.com">Главная</a>
    &nbsp
    <a href="/chat">Чат</a>
    &nbsp
    <a href="gallery.php">Галерея</a>
    &nbsp
    <a href="/wiki">Вики</a>
     &nbsp
    <a href="prislatstatiy.html">Прислать статью</a>
      &nbsp
    <a href="/fetchtok">FetchTok</a>
    <hr>
    <h1>Добро пожаловать на Linux-hub!</h1>
    <li>Публикуйте интересные статьи</li>
    <li>Общайтесь с другими линуксоидами в чате</li>
    <li>Включайте Ваш /dev/brain на полную мощность и наслаждайтесь уютным linux-community!</li>
    <hr>
    <div class="articles">
        <h2>Статьи</h2>
        <ul>
            <?php
            // Укажите путь к папке со статьями
            $articlesDir = 'statyi';

            // Проверяем, существует ли папка
            if (is_dir($articlesDir)) {
                // Получаем список файлов в папке
                $files = scandir($articlesDir);

                // Перебираем файлы
                foreach ($files as $file) {
                    // Пропускаем текущую и родительскую директории
                    if ($file === '.' || $file === '..') {
                        continue;
                    }

                    // Проверяем поддерживаемые расширения (.txt и .md)
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if ($ext === 'txt' || $ext === 'md') {
                        // Открываем файл для чтения
                        $filePath = $articlesDir . '/' . $file;
                        $handle = fopen($filePath, 'r');

                        // Читаем первую строку (название статьи)
                        $title = fgets($handle);
                        fclose($handle);

                        // Выводим ссылку на статью
                        echo '<li><a href="viewer.php?file=' . urlencode($filePath) . '">' . htmlspecialchars($title) . '</a>';
                        echo ' <small>(' . strtoupper($ext) . ')</small></li>';
                    }
                }
            } else {
                echo '<li>Папка со статьями не найдена.</li>';
            }
            ?>
        </ul>
    </div>
    <hr>
    <h2>Новости</h2>
    <table>
  <script language=JavaScript src="http://www.opennet.ru/opennews/opennews_5.js"></script>
  </table>
    <hr>
<a href= "http://linux.mypressonline.com/friends.html"> Наши друзья </a>
    <div class="buttons">
       
    </div>
</body>
</html>