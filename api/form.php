<?php

require '../exec/Database.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);


// INSERT INTO `produto` (`id`, `nome`, `preco`, `quantidade_estoque`) VALUES (NULL, 'celular LG', 100, 10);

$table = $input['table'];

$insert = "INSERT INTO $table (";

foreach ($input['form'] as $key => $form) {
    if ($key)
        $insert .= "," . $form['field'];
    else
        $insert .= $form['field'];
}

$insert .= ") VALUES (";

$params = [];
foreach ($input['form'] as $key => $form) {
    if ($key)
        $insert .= ",:" . $form['field'];
    else
        $insert .= ":" . $form['field'];
    $params[$form['field']] = $form['value'];
}

$insert .= ");";

$db = new Database();
$db->execute($insert, $params);

echo json_encode(
    [
        'status' => true,
        'mensagem' => 'salvo com sucesso'
    ]
);


