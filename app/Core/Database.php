<?php
class Database
{
    private static $instance;
    private $connection;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'u579415994_kmps';

    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }
    public function real_escape_string($string)
    {
        return $this->connection->quote($string);
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
