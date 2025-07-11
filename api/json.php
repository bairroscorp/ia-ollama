<?php

require '../exec/Database.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);

$caminho = '../exec/lowcode';

if (!is_dir($caminho)) {
    return [];
}

$file_name = $input['fileName'];

// PRECISA PENSAR EM UMA FORMA DE RODAR A QUERY AQUI PARA ALIMENTAR OS 
//$file_name = '20250711045230.json';

$josn = json_decode(file_get_contents($caminho . '/' . $file_name));

foreach ($josn as $key => $j) {
    if (!empty($j->data_source)) {
        $db = new Database();
        try{
            $josn[$key]->data = $db->select($j->data_source);
        }catch(Exception $e) {

        }
    }
    //var_dump($josn);die();
}

echo json_encode($josn);
