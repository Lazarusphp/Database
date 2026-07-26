<?php
namespace ElegenceIO\Database;

use PDO;

class Connection
{
    private bool $isConnected = false;
    private ?PDO $pdo = null;
    public function __construct(array &$config)
    {

        $this->pdo = $this->make($config);
    }

    private function make(array $config)
    {
        $dsn = $config["driver"].":host=".$config["hostname"].";dbname=".$config["name"];
        $this->isConnected = true;    
        return new PDO ($dsn,$config["user"],$config["password"],$this->options());
        
    }

    private function options():array
    {
           return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }


    public function connect() :object 
    {
        return $this->pdo;   
    }
}