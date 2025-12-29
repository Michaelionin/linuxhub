<!-- publish.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Загрузить - FetchTok</title>
    <style>
        body { background-color: #000; color: #0F0; font-family: 'Courier New', Courier, monospace; margin: 20px; }
        a { color: #0F0; text-decoration: underline; }
        a:hover { color: #FFF; }
        h1 { font-size: 24px; text-align: center; }
        hr { border: 1px solid #0F0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea { 
            background: #000;
            color: #0F0;
            border: 1px solid #0F0;
            padding: 8px;
            width: 100%;
            max-width: 500px;
            font-family: inherit;
        }
        button { 
            background: #0F0; 
            color: #000; 
            border: none; 
            padding: 10px 20px; 
            cursor: pointer; 
            font-family: inherit;
            font-weight: bold;
        }
        .container { max-width: 600px; margin: 0 auto; }
        .error { color: #F00; }
        .success { color: #0F0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Загрузить скриншот</h1>
        <div class="nav">
            <a href="index.php">← На главную</a>
        </div>
        <hr>
    </div>

    <div class="container">
        <?php
        include('settings.php');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author = trim($_POST['author'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $error = '';
            
            // Валидация (ИСПРАВЛЕННЫЙ СИНТАКСИС)
            if (empty($author)) {
                $error = "Необходимо имя автора";
            } elseif (empty($_FILES['screenshot']['tmp_name'])) {
                $error = "Скриншот необходим";
            } elseif ($_FILES['screenshot']['size'] > MAX_FILE_SIZE) {
                $error = "Файл слишком большой (max 2MB)";
            }
            
            if (!$error) {
                // Генерация уникального имени
                $filename = uniqid('fetch_', true) . '.jpg';
                $txtFilename = str_replace('.jpg', '.txt', $filename);
                
                // Сохранение изображения
                $tempFile = $_FILES['screenshot']['tmp_name'];
                $targetFile = UPLOAD_DIR . $filename;
                
                if (move_uploaded_file($tempFile, $targetFile)) {
                    // Создание мета-файла
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $content = "$description\n$author\n0\n$email\n$ip";
                    file_put_contents(UPLOAD_DIR . $txtFilename, $content);
                    
                    echo '<p class="success">Загрузка успешна!</p>';
                    echo '<p><a href="index.php">Смотреть посты</a></p>';
                } else {
                    $error = "Ошибка";
                }
            }
            
            if ($error) {
                echo '<p class="error">Error: ' . htmlspecialchars($error) . '</p>';
            }
        }
        ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="author">Имя/ник:</label>
                <input type="text" id="author" name="author" required maxlength="50">
            </div>
            
            <div class="form-group">
                <label for="email">Email (по желанию):</label>
                <input type="email" id="email" name="email" maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea id="description" name="description" rows="3" maxlength="200"></textarea>
            </div>
            
            <div class="form-group">
                <label for="screenshot">Скриншот (JPG, max 2MB):</label>
                <input type="file" id="screenshot" name="screenshot" accept="image/jpeg" required>
            </div>
            
            <button type="submit">Опубликовать</button>
        </form>
    </div>
</body>
</html>