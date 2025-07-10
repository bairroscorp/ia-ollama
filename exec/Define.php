<?php

require 'Database.php';

class Define
{
    private $db;
    private $result;

    public function __construct($prompt, $type)
    {
        switch ($type) {
            case '.lowcode':
                $this->result = $this->lowcode($prompt);
                break;
            case '.sql':
                $this->db = new Database();
                if (stripos($prompt, 'select') !== false) {
                    $this->result = $this->query($prompt);
                } elseif (stripos($prompt, 'SELECT') !== false) {
                    $this->result = $this->query($prompt);
                } else {
                    $this->result = $this->execute($prompt);
                    if($this->result) {
                        $this->result = "Rodei no banco isso $prompt";
                    }
                }
                break;
            default:
                $this->result = $this->setDefault();
                break;
        }
    }

    private function lowcode($prompt)
    {
        $dir = '/var/www/html/twn/exec/lowcode';

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $file_name = date('Ymdhis');

        file_put_contents($dir . "/$file_name.json", $prompt);

        return "Tela low-code criada com sucesso!";
    }

    private function query($sql, $params = [])
    {
        return $this->db->select($sql, $params);
    }

    private function execute($sql, $params = [])
    {
        return $this->db->execute($sql, $params);
    }

    private function setDefault()
    {
        return "Desculpe, eu não encontrei o prompt para treinamento...";
    }

    public function getResult()
    {
        return $this->result;
    }
}
