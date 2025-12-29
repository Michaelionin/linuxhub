<?php
// Обработка GET-запросов от Lite-версии
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nick']) && isset($_GET['msg'])) {
    $nickname = substr(strip_tags($_GET['nick']), 0, 15);
    $message = substr(strip_tags($_GET['msg']), 0, 80);
    
    if ($nickname && $message) {
        $file = 'messages.txt';
        $entry = date('H:i:s') . '|' . $nickname . '|' . $message . "\n";
        
        // Читаем существующие сообщения
        $messages = [];
        if (file_exists($file)) {
            $messages = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            // Ограничиваем до 50 сообщений
            if (count($messages) >= 50) {
                array_shift($messages);
            }
        }
        
        // Добавляем новое сообщение
        $messages[] = $entry;
        file_put_contents($file, implode("\n", $messages) . "\n", LOCK_EX);
        
        // Перенаправляем обратно
        header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'chatLite.html'));
        exit;
    }
}

// Если что-то пошло не так
header('Location: chatLite.html');
exit;
?>