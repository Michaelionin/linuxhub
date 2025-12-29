<?php
header('Content-Type: application/json');

$smilesDir = 'smiles';
$allowedExtensions = ['gif', 'png', 'jpg', 'jpeg'];
$smiles = [];

if (is_dir($smilesDir)) {
    $files = scandir($smilesDir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $allowedExtensions)) {
            $smiles[] = $file;
        }
    }
}

echo json_encode($smiles);