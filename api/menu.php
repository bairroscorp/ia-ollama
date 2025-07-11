<?php

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);

$caminho = '../exec/lowcode';

if (!is_dir($caminho)) {
    return [];
}

$arquivos = array_filter(scandir($caminho), function ($item) use ($caminho) {
    return is_file($caminho . DIRECTORY_SEPARATOR . $item);
});

$arrayAquivos = array_values($arquivos);

$menu = [];

foreach ($arrayAquivos as $arquivo) {
    $josn = json_decode(file_get_contents($caminho . '/' . $arquivo));
    $menu[] = $josn[0];
}

echo json_encode($menu);