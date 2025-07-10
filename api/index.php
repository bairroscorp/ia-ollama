<?php

require_once 'Assistente.php';
require_once '../exec/Define.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['chave'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Chave não informada']);
    exit;
}

$chave = preg_replace('/[^0-9]/', '', $input['chave']);

$type = $input['type'];

$caminho = __DIR__ . '/storage/.' . $chave;

if (!is_dir($caminho)) {
    http_response_code(404);
    echo json_encode(['erro' => 'Token inválido!']);
    exit;
}

$path = $caminho . '/' . $type;

if (!file_exists($path)) {
    http_response_code(404);
    echo json_encode(['erro' => 'Prompt de treinamento não existe para esse token!']);
    exit;
}

$conteudo = file_get_contents($path);

$conteudo = $conteudo . ' ' . $input['prompt'];

$assistente = new Assistente($conteudo);

$conteudo = $assistente->executar();

if ($type !== '.chat') {
    $define = new Define($conteudo, $type);
    $conteudo = $define->getResult();
}

echo json_encode(
    [
        'chave' => $chave,
        'conteudo' => $conteudo
    ]
);
