<?php
// send_message.php

// Функция для проверки запрещенных слов в нике
function isNicknameBanned($nickname) {
    if (!file_exists('bannednicks.txt')) {
        // Если файл не существует, создаем его с примерами
        file_put_contents('bannednicks.txt', "admin\nmoderator\nroot\nsupport");
    }
    
    $bannedWords = file('bannednicks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lowerNick = strtolower($nickname);
    
    foreach ($bannedWords as $word) {
        if (strpos($lowerNick, strtolower($word)) !== false) {
            return true;
        }
    }
    return false;
}

if(isset($_POST['message']) && isset($_POST['nickname'])) {
    $nickname = substr(strip_tags($_POST['nickname']), 0, 20);
    $message = substr(strip_tags($_POST['message']), 0, 100);
    
    // Проверка на пустые значения
    if(empty($nickname) || empty($message)) {
        die("Никнейм и сообщение не могут быть пустыми");
    }
    
    // Проверка на запрещенные никнеймы
    if(isNicknameBanned($nickname)) {
        die("Ваш никнейм запрещен");
    }
    
    // Защита от флуда (не чаще 1 сообщения в 3 секунды)
    session_start();
    $lastMessageTime = $_SESSION['last_message_time'] ?? 0;
    $currentTime = time();
    
    if($currentTime - $lastMessageTime < 3) {
        die("Вы отправляете сообщения слишком часто");
    }
    
    $_SESSION['last_message_time'] = $currentTime;
    
    // Если все проверки пройдены, сохраняем сообщение
    $file = 'messages.txt';
    $entry = date('H:i:s') . '|' . $nickname . '|' . $message . "\n";
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
}