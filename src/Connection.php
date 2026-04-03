<?php
namespace LazarusPhp\Database;

use Exception;
use PDO;
use PDOStatement;
use RuntimeException;
use LazarusPhp\PathResolver\Resolve;

abstract class Connection
{
    private static array $config = [];
    private PDOStatement $connection;
    private static ?PDO $pdo = null;
    private static array $required = ["DRIVER","HOSTNAME","USER","PASSWORD","NAME"]; 

    private static  function ValidateRequirements(array $connection)
    {
         foreach($connection as $key => $value)
        {
            if(!in_array($key,self::$required))
            {
                throw new Exception("Invalid  key {$key} passed  supported keys : " . implode(", ",self::$required));
            }
        }
    }

    public static function make(array $connection):void
    {        

    // Validate Keys Match With Connection Variables;
            self::ValidateRequirements($connection);

            self::$config = [
                "type"=>($connection["DRIVER"]),
                "hostname"=>($connection["HOSTNAME"]),
                "username"=>($connection["USER"]),
                "password"=>($connection["PASSWORD"]),
                "dbname"=>($connection["NAME"]),
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