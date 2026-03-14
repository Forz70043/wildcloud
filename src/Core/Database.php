<?php

namespace WildCloud\Core;

use PDO;
use PDOException;

class Database 
{
    private ?PDO $connection = null;
    private string $charset = 'utf8mb4';

    /**
     * @param string|null $host
     * @param string|null $dbname
     * @param string|null $user
     * @param string|null $pass
     */
    public function __construct(
        private ?string $host = null,
        private ?string $dbname = null,
        private ?string $user = null,
        private ?string $pass = null
    ) {
        $this->host   = $host   ?? getenv('DB_HOST') ?: 'localhost';
        $this->dbname = $dbname ?? getenv('DB_NAME') ?: 'wildcloud';
        $this->user   = $user   ?? getenv('DB_USER') ?: 'root';
        $this->pass   = $pass   ?? getenv('DB_PASS') ?: '';
    }

    /**
     * @return PDO
     */
    public function connect(): PDO 
    {
        if ($this->connection === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Transform error SQL in exception
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // return associative array by default
                PDO::ATTR_EMULATE_PREPARES   => false,                  // Extra security for SQL injection, use real prepared statements if supported by the driver
            ];

            try {
                $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (PDOException $e) {
                // In production, you might want to log the error instead of displaying it
                throw new PDOException("Connection error");
            }
        }

        return $this->connection;
    }
}