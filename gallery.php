<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея Linux-hub</title>
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
        .gallery {
            text-align: center;
            margin-top: 20px;
        }
        .gallery img {
            border: 2px solid #0F0;
            margin: 10px;
            max-width: 100%;
            height: auto;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
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
    <a href="/fetchhub">FetchHub</a>
    <hr>
    <h1>Галерея Linux-hub</h1>

    <div class="gallery">
        <?php
        // Укажите путь к папке с изображениями
        $galleryDir = 'gallery';

        // Проверяем, существует ли папка
        if (is_dir($galleryDir)) {
            // Получаем список файлов в папке
            $images = scandir($galleryDir);

            // Перебираем файлы
            foreach ($images as $image) {
                // Пропускаем текущую и родительскую директории
                if ($image === '.' || $image === '..') {
                    continue;
                }

                // Проверяем, что файл является изображением
                $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Выводим изображение
                    echo '<img src="' . $galleryDir . '/' . $image . '" alt="' . $image . '">';
                }
            }
        } else {
            echo '<p>Папка с изображениями не найдена.</p>';
        }
        ?>
    </div>

    <hr>

    <div class="buttons">
        
    </div>
</body>
</html>