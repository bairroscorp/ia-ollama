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
}
