# SUC *~Think With Neurons~*

**API + IA + Roteador de treinamento + Roteador de response**

# API 
descrição: API, vai receber chamadas post com um token, esse token sera uma pasta dentro do projeto, sendo assim, ele vai guardar os promps para aquela chamada.
vai os seguintes prompt: 
.interativo
.relaroriosql
.createtable
.lowcode
.help

* 1º prompet de converça, ele deve saber que o nome dela é TWN, e responder as pergunta.
* 2º faça um relatório, ele deve ter o conhecimento da estrutura do banco para executar o sql.
* 3º crie uma tabel, ele deve executar sql.
* 4º crie uma tela, ele deve executar mkdir para gerar o json e criar a tebal escrevendo as regras do low-code dentro da tela, para isso aqui funcionar, preciso ter um  prompt de treinamento com todas as informações das telas low-code, como uma documentação!

# Roteamento API
descrição: Responsável por realizar interpretar a chamada, devera descidir qual prompt aplicar!

# Roteamento de execução
descrição: responsável por realizar a chamada e receber o response, ao receber o responce ele tera que descidir se executa como comando shell linux, Query DB ou Retorna como mensagem para o usuário.

# LAYOUT DEFAULT 
descrição: para mostra funcionando para o Pedro, vou criar um beta, com layout preto, onde ele vai converçar como o chatGTP, criar menus no site e até umas telinhas, gerar alguns relatórios ou algo do tipo!
como é só um prototipo, eu vou usar um token qualquer, porque tanto faz por hora, tem muita coisa para desenvolver e realmente criar aqui.

# Configuração de ambiente...
*~ IA + LINUX + PHP~*

curl -fsSL https://ollama.com/install.sh | sh
ollama run mistral

$safePrompt = escapeshellarg($prompt);
$cmd = "echo $safePrompt | ollama run mistral";
$output = shell_exec($cmd);
