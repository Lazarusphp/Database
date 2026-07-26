<?php
namespace ElegenceIO\Database;
use ElegenceIO\Database\Database;
use PDOStatement;

class TestDb
{
    
    private static ?PDOStatement $instace = null;
    
    public function __construct(private array $config)
    {
        $this->config = $config;
    }

    public function load()
    {
        \var_dump($this->config);
    }
}