<?php
namespace ElegenceIO\Database;

use Exception;
use ElegenceIO\Database\Connection;
use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

class Database 
{

    protected ?PDOStatement $stmt = null;
    private array $config;
    private ?Connection $connection = null;
    private ?PDO $pdo = null;

    public function __construct(array $config)
    {
        $this->connection = new Connection($config);
        $this->pdo = $this->connection->connect();
    }


    
    public function pdo()
    {
        return $this->pdo;
    }


    // Begin transaction
    protected function beginTransaction()
    {
        try {
            $this->pdo()->beginTransaction();
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to begin transaction: " . $e->getMessage(), (int)$e->getCode());
        }
    }
        // $this->pdo()->beginTransaction();

    // Commit transactoin
    protected function commit()
    {
        try {
            $this->pdo()->commit();
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to commit transaction: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    // RollBack a transaction if failed
    protected function rollback()
    {
        try {
            $this->pdo()->rollback();
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to rollback transaction: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    // Set Prepare Statement using prepart
    protected function prepare(string $sql)
    {
        return $this->pdo()->prepare($sql);
    }

    // Set prepare statements using query
    protected function query(string $sql)
    {
        return $this->pdo()->query($sql);
    }

     protected function lastId()
    {
        return $this->connection->connect()->lastInsertId();
    }
    
}