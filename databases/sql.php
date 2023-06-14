<?php

namespace databases;

use helpers\EnvHandler;
use PDO;
use PDOException;
use PDOStatement;

class Sql extends Database
{
    protected string $hostname;
    protected string $username;
    protected string $database;
    protected string $charset;
    private PDO $connection;
    private PDOStatement $stmt;

    public function __construct()
    {
        $this->hostname = EnvHandler::getConfig('SQL_DB_HOST');
        $this->username = EnvHandler::getConfig('SQL_DB_USERNAME');
        $this->password = EnvHandler::getConfig('SQL_DB_PASSWORD');
        $this->database = EnvHandler::getConfig('SQL_DB_DATABASE');
        $this->charset  = EnvHandler::getConfig('SQL_DB_CHARSET');
        $this->connection();
    }

    public function connection()
    {
        $dns = "mysql:host={$this->hostname};dbname={$this->database};charset={$this->charset}";
        try {
            $this->connection = new PDO($dns, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Помилка при підключенні до БД.');
        }
    }

    public function query(string $sql, $data = []): Sql
    {
        try {
            $this->stmt = $this->connection->prepare($sql);

            if (!empty($data)) {
                foreach ($data as $key => &$value) {
                    $this->stmt->bindParam($key, $value);
                }
            }

            $this->stmt->execute();
            return $this;
        } catch (PDOException $e) {
            die('Неправильно сформовано SQL запит.');
        }
    }

    public function get($mode = PDO::FETCH_ASSOC): bool|array
    {
        return $this->stmt->fetchAll($mode);
    }


    public function first($mode = PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetch($mode);
    }
}
