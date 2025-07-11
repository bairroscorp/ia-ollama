<?php

header("Content-Type: application/json");

$caminho = '../exec/lowcode';

if (!is_dir($caminho)) {
    return [];
}

$arquivos = array_filter(scandir($caminho), function ($item) use ($caminho) {
    return is_file($caminho . DIRECTORY_SEPARATOR . $item) && pathinfo($item, PATHINFO_EXTENSION) === 'json';
});

$arrayAquivos = array_values($arquivos);

$menu = [];

foreach ($arrayAquivos as $arquivo) {

    $conteudo = file_get_contents($caminho . '/' . $arquivo);

    $josn = json_decode($conteudo);

    $menu[] = [
        'title' => $josn[0]->title,
        'file_name' => $arquivo
    ];
}

echo json_encode($menu);