<?php

class Assistente
{
    private string $prompt;
    private bool $logAtivado = true;
    private string $modelo = 'mistral';

    public function __construct(string $prompt)
    {
        $this->prompt = $prompt;
    }

    public function executar(): string
    {
        if (empty(trim($this->prompt))) {
            return "Prompt vazio.";
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'prompt_');
        file_put_contents($tempFile, $this->prompt);

        $cmd = "export HOME=/root; /usr/local/bin/ollama run {$this->modelo} < $tempFile 2>&1";

        $this->log("Comando shell executado: $cmd");

        $output = shell_exec($cmd);

        // Remove o arquivo temporário
        unlink($tempFile);

        if (!$output) {
            return "Erro ao chamar o Ollama.";
        }

        $output = $this->removeAnsiCodes($output);

        $output = $this->limparResposta($output);

        $this->log("Saída do Ollama:\n" . $output);

        return $output;
    }

    private function removeAnsiCodes(string $text): string
    {
        return preg_replace('/\e\[[\d;?]*[A-Za-z]/', '', $text);
    }

    private function limparResposta(string $texto): string
    {
        // Remove sequências ANSI
        $texto = preg_replace('/\e\[[\d;?]*[A-Za-z]/', '', $texto);

        // Remove caracteres do spinner (braille patterns e similares)
        $texto = preg_replace('/[\x{2800}-\x{28FF}]/u', '', $texto); // Unicode blocos braille

        // Remove espaços extras deixados pelos spinners
        return trim($texto);
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
        } else {
            error_log("Não foi possível escrever no diretório de log: $logDir");
        }
    }
}
