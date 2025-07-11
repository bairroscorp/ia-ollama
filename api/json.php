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
            try {
                $josn[$key]->data = $db->select($j->data_source);
            } catch (Exception $e) {
            }

            if (!empty($j->components)) {
                foreach ($j->components as $key_component => $component) {

                    if ($component->options_query) {

                        $josn[$key]->components[$key_component]->data = $db->select($component->options_query);
                    }
                }
            }
        } catch (Exception $e) {
        }
    }
}

echo json_encode($josn);
