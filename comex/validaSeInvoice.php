<?php

require '../vendor/autoload.php';
require '../api/Assistente.php';

use Smalot\PdfParser\Parser;

$path = '/var/www/html/twn/api/storage/.00000001/.invoice';
$treinamento = file_get_contents($path);

$parser = new Parser();
$conteudo_arquivo = $parser->parseFile('/var/www/html/twn/comex/015558-24/INVOICE_MEX26235.pdf')->getText();
$prompt = $treinamento." ". $conteudo_arquivo;

//print_r($prompt);die();

$assistente = new Assistente($prompt);
$resposta = $assistente->executar();

print_r($resposta);

print_r("\n\n\n");