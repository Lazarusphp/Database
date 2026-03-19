<?php
namespace LazarusPhp\Database;

use PDOStatement;
use Pdo;
use PDOException;

class Store
{
    private $connection;
    private $rows;

    public function __construct()
    {
        $this->connection = Connection::get();
    }

    public function parse(string $sql,array $params,$qtype="select")
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

            $stmt->execute();
            return match($qtype)
            {
                "insert","update","replace","delete" => $stmt->rowCount(),
                default => $stmt,
            };

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