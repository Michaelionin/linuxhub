<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>FetchTok</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #000;
            color: #0F0;
            font-family: 'Courier New', Courier, monospace;
            margin: 20px;
            line-height: 1.6;
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
            margin-bottom: 30px;
        }
        hr {
            border: 1px solid #0F0;
            margin: 20px 0;
        }
        .post {
            margin-bottom: 40px;
            padding: 15px;
            border: 1px solid #0F0;
            border-radius: 3px;
        }
        .post img {
            max-width: 100%;
            border: 1px solid #333;
            display: block;
            margin: 10px 0;
        }
        .like-btn {
            background: #0F0;
            color: #000;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-family: inherit;
            font-weight: bold;
            margin-top: 10px;
        }
        .like-btn:hover {
            background: #0A0;
        }
        .like-count {
            margin-left: 10px;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .nav {
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FETCHTOK</h1>
        <div class="nav">
            <a href="index.php">Главная</a> | 
            <a href="publish.php">Загрузить скриншот</a>
        </div>
        <hr>
    </div>

    <?php
    include('settings.php');
    
    // Получаем список постов
    $files = glob(UPLOAD_DIR . "*.txt");
    rsort($files); // Сортировка по убыванию (новые сверху)
    
    if (count($files) > 0) {
        foreach ($files as $txtFile) {
            $imgFile = str_replace('.txt', '.jpg', $txtFile);
            $data = file($txtFile, FILE_IGNORE_NEW_LINES);
            
            if ($data && count($data) >= 3 && file_exists($imgFile)) {
                $description = htmlspecialchars($data[0]);
                $author = htmlspecialchars($data[1]);
                $likes = intval($data[2]);
                $filename = basename($imgFile);
                
                echo '<div class="post">';
                echo "<strong>$author</strong><br>";
                echo "$description<br>";
                echo '<img src="'.htmlspecialchars($imgFile).'" alt="'.$description.'">';
                echo '<button class="like-btn" data-id="'.htmlspecialchars($filename).'">LIKE</button>';
                echo '<span class="like-count" id="likes-'.htmlspecialchars($filename).'">'.$likes.'</span>';
                echo '</div>';
            }
        }
    } else {
        echo "<p>Нет постов. <a href='publish.php'>Загрузите </a>первый!</p>";
    }
    ?>

    <div class="footer">
        <hr>
        <p>FetchTok </p>
    </div>

    <script>
        // AJAX для лайков
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const filename = this.getAttribute('data-id');
                const likeCount = document.getElementById('likes-' + filename);
                
                fetch('like.php?file=' + encodeURIComponent(filename))
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            likeCount.textContent = data.likes;
                        }
                    });
            });
        });
    </script>
</body>
</html>