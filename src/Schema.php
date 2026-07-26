<?php
namespace ElegenceIO\Database;

use ElegenceIO\Database\Connection;
use ElegenceIO\Database\Store;

class Schema
{

    private $connection;
    private Store $store;

    public function __construct(object $connection)
    {
        $this->connection = $connection;
        $this->store = new Store($connection);

    }
    
    public function hasTable(string $table):bool|int|null
    {

        $dbname = env("dbname");
        $q = "SELECT 1 
        FROM information_schema.tables 
        WHERE table_schema = :hostname 
        AND table_name = :table  
        LIMIT 1";

        $stmt = $this->store->parse($q,[]);
    
        $row = $stmtp[0] ?? null;

        if(!$row)
        {
            return false;
        }

        return $row;
    }
}