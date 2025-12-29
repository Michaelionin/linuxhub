<?php
$file = 'messages.txt';
$messages = [];

if (file_exists($file)) {
    $messages = array_reverse(file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
}

foreach ($messages as $msg) {
    list($time, $nick, $text) = explode('|', $msg, 3);
    echo '<div class="message">'
        . '<span class="time">[' . htmlspecialchars($time) . ']</span> '
        . '<span class="nickname">' . htmlspecialchars($nick) . ':</span> '
        . htmlspecialchars($text)
        . '</div>';
}
?>