<?php
// like.php - обработка лайков
include('settings.php');

if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $txtFile = UPLOAD_DIR . str_replace('.jpg', '.txt', $filename);
    
    if (file_exists($txtFile)) {
        $data = file($txtFile, FILE_IGNORE_NEW_LINES);
        
        if ($data && count($data) >= 3) {
            // Увеличиваем счетчик лайков
            $data[2] = intval($data[2]) + 1;
            
            // Сохраняем обновленные данные
            $content = implode("\n", array_slice($data, 0, 3));
            if (count($data) > 3) {
                $content .= "\n" . implode("\n", array_slice($data, 3));
            }
            
            file_put_contents($txtFile, $content);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'likes' => $data[2]]);
            exit;
        }
    }
}

header('Content-Type: application/json');
echo json_encode(['success' => false]);
?>