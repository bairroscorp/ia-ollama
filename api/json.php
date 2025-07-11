<?php

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);

$caminho = '../exec/lowcode';

if (!is_dir($caminho)) {
    return [];
}

$file_name = $input['fileName'];
//$file_name = '20250710024637.json';

$josn = json_decode(file_get_contents($caminho . '/' . $file_name));

echo json_encode($josn);