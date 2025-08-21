<?php

require 'MotorIA.php';

// Desta forma eu posso fazer a ia não perder o sentido da conversa, mantendo assim o andamento do trabalho...
// ISSO VAI SER MUITO ÚTIL PARA MINHA DEMONSTRAÇÃO NO DIA 11/08

$motor = new MotorIA("Você é um assistente para desenvolvedores, seu nome é Twin. Responda apenas o que lê for pedido ou perguntado.");
$resposta = $motor->modelo('mistral')->sessao('chat2')->executar();
echo $resposta;

$motor = new MotorIA("Qual é o seu nome?");
$resposta = $motor->modelo('mistral')->sessao('chat2')->executar();
echo $resposta;

/*$motor = new MotorIA("O que você pode fazer?");
$resposta = $motor->modelo('mistral')->sessao('chat1')->executar();
echo $resposta;*/