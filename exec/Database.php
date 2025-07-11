<?php

class Database
{
    private $pdo;
    private $host = 'localhost';
    private $dbname = 'suc';
    private $username = 'suc';
    private $password = 'suc';

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    // SELECT com ou sem parâmetros
    public function select($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // INSERT, UPDATE, DELETE
    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Último ID inserido
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    // Conexão bruta (opcional)
    public function getConnection()
    {
        return $this->pdo;
    }

    public function getEstruturaBancoJson()
    {
        $sql = "SELECT table_name, column_name, data_type, is_nullable, column_key
            FROM information_schema.columns
            WHERE table_schema = :dbname
            ORDER BY table_name, ordinal_position";

        $colunas = $this->select($sql, ['dbname' => $this->dbname]);
       
        $estrutura = [];
        foreach ($colunas as $coluna) {
            $estrutura[$coluna['TABLE_NAME']][] = [
                'nome' => $coluna['COLUMN_NAME'],
                'tipo' => $coluna['DATA_TYPE'],
                'nulo' => $coluna['IS_NULLABLE'],
                'chave' => $coluna['COLUMN_KEY']
            ];
        }

        return json_encode($estrutura, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
