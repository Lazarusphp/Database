<?php
namespace LazarusPhp\Database;

use PDOStatement;
use Pdo;

class Store
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }
    
    public function parse(string $sql,array $params)
    {   
        // Process Query 
            $stmt = $this->connection->prepare($sql);
        
            if (!empty($params)) {
            // Prepare code
            foreach ($params as $key => $value) {
                $type = $this->getParamType($value);
                $stmt->bindValue($key, $value, $type);
            }
        }
            $stmt->execute($params);
            return $stmt;
    }


    private function getParamType($value)
    {
        switch ($value) {
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            case is_int($value):
                return PDO::PARAM_INT;
            case is_string($value):
                return PDO::PARAM_STR;
            default;
                break;
        }
    }
}