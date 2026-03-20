<?php
namespace LazarusPhp\Database;

use PDO;
use PDOStatement;
use RuntimeException;

abstract class Connection
{
    private static array $config = [];
    private PDOStatement $connection;
    private static ?PDO $pdo = null;
    
    public static function make(?string $type=null,?string $hostname=null,?string $username=null,?string $password=null,?string $dbname=null):void
    {
        self::$config = 
        [
            "type"=>($type ?? $_ENV["type"]),
            "hostname"=>($hostname ?? $_ENV["hostname"]),
            "username"=>($username ?? $_ENV["username"]),
            "password"=>($password ?? $_ENV["password"]),
            "dbname"=>($dbname ?? $_ENV["dbname"]),
        ];
    }



    public static function get()
    {
        if(!self::$pdo)
        {
            if(empty(self::$config))
            {
                throw new RuntimeException("Connection Not Made : Call `Connection::make()` first ");
            }

            self::$pdo = self::connect();
        }
        
        return self::$pdo;
    }

    private static function connect()
    {
        $config = self::$config;
        $dsn = $config["type"].":host=".$config["hostname"].";dbname=".$config["dbname"];
        return new PDO($dsn,$config["username"],$config["password"],self::options());
    }

    private static function options():array
    {
          return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

    }
    
    public static function retrieve():array
    {
        return self::$config;
    }

}