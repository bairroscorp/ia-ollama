<?php

require '../vendor/autoload.php';
require '../api/Assistente.php';

use Smalot\PdfParser\Parser;

$path = '/var/www/html/twn/api/storage/.00000001/.invoicepackinglist';
$treinamento = file_get_contents($path);

$parser = new Parser();
$conteudo_arquivo_inv = $parser->parseFile('/var/www/html/twn/comex/015558-24/INVOICE_MEX26235.pdf')->getText();
$conteudo_arquivo_pack = $parser->parseFile('/var/www/html/twn/comex/015558-24/PACKINGLIST.pdf')->getText();

$prompt = $treinamento." 

=== INVOICE ===

". $conteudo_arquivo_inv;
$prompt .= "

=== PACKING LIST ===

".$conteudo_arquivo_pack;

$assistente = new Assistente($prompt);
$resposta = $assistente->executar();

print_r($resposta);

print_r("\n\n\n");