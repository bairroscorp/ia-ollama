<?php

class MotorIA
{
    private string $modelo = 'mistral';
    private string $prompt;
    private string $url = 'http://localhost:11434/api/chat';
    private ?string $sessao = null;
    private bool $logAtivado = true;
    private static array $sessoes = [];

    public function __construct(string $prompt)
    {
        $this->prompt = $prompt;
    }

    public function modelo(string $modelo): self
    {
        $this->modelo = $modelo;
        return $this;
    }

    public function sessao(string $nome): self
    {
        $this->sessao = $nome;
        return $this;
    }

    public function executar(): string
    {
        if (empty(trim($this->prompt))) {
            return "Prompt vazio.";
        }

        // Histórico de mensagens
        $mensagens = [];

        if ($this->sessao && isset(self::$sessoes[$this->sessao])) {
            $mensagens = self::$sessoes[$this->sessao];
        }

        $mensagens[] = [
            'role' => 'user',
            'content' => $this->prompt
        ];

        $payload = [
            'model' => $this->modelo,
            'messages' => $mensagens,
            'stream' => false
        ];

        $response = $this->fazerRequisicao($payload);

        if (!$response || !isset($response['message']['content'])) {
            return "Erro na resposta do Ollama.";
        }

        $resposta = trim($response['message']['content']);

        // Armazena no histórico da sessão
        if ($this->sessao) {
            $mensagens[] = [
                'role' => 'assistant',
                'content' => $resposta
            ];
            self::$sessoes[$this->sessao] = $mensagens;
        }

        $this->log("Usuário: {$this->prompt}\nIA: $resposta");

        return $resposta;
    }

    private function fazerRequisicao(array $dados): ?array
    {
        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $resposta = curl_exec($ch);

        if (curl_errno($ch)) {
            $erro = curl_error($ch);
            curl_close($ch);
            $this->log("Erro cURL: $erro");
            return null;
        }

        curl_close($ch);
        return json_decode($resposta, true);
    }

    private function log(string $mensagem): void
    {
        if (!$this->logAtivado) return;

        $logDir = __DIR__ . '/log';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logfile = $logDir . '/log.log';
        $linha = "[" . date('Y-m-d H:i:s') . "] " . $mensagem . PHP_EOL;

        if (is_writable($logDir)) {
            file_put_contents($logfile, $linha, FILE_APPEND);
        }
    }
}