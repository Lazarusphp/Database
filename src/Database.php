<?php
namespace LazarusPhp\Database;

use Exception;
use LazarusPhp\Database\Connection;
use PDO;
use PDOException;
use PDOStatement;
use RuntimeException;

abstract class Database 
{
    

    protected ?PDOStatement $stmt = null;
    private array $config;
    private static $connection;
    protected static $isConnected = false;

    public function __construct()
    {
        $this->pdo();
    }

    public function pdo()
    {
        return Connection::get();
    }

    protected function hasTable(string $table):bool
    {
        
        if(!self::$isConnected)
        {
            throw new Exception("No Connection Found");
        }
        
    
        $hostname = env("dbname");
        $q = "SELECT 1 
        FROM information_schema.tables 
        WHERE table_schema = :hostname 
        AND table_name = :table  
        LIMIT 1";

        echo $q;

        $stmt = $this->pdo()->prepare($q);
        $stmt->execute([
        ":hostname"=>$this->config["dbname"],
        ":table"=>$table]);

        return $stmt->fetch() !== false;
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
        return Connection::get()->lastInsertId();
    }
    
}