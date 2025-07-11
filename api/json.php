<?php

require '../exec/Database.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);

$caminho = '../exec/lowcode';

if (!is_dir($caminho)) {
    return [];
}

$file_name = $input['fileName'];
$josn = json_decode(file_get_contents($caminho . '/' . $file_name));

foreach ($josn as $key => $j) {
    if (!empty($j->data_source)) {
        try {
            $db = new Database();
            $josn[$key]->data = $db->select($j->data_source);
        } catch (Exception $e) {
            // AQUI TEM QUE PENSAR EM ALGUMA FORMA DE MONTAR UM LOG OU ALGUM AVISO DE QUE NÃO DEU CERTO.
        }
    }
}

echo json_encode($josn);
