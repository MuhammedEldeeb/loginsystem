<?php

class DB_Connector
{
    private static $servername = 'localhost';
    private static $username = 'root';
    private static $password = '';
    private static $dbname = 'login_system';

    public static function connect()
    {
        $dsn = 'mysql:host=' . self::$servername . ';dbname=' . self::$dbname;

        try{
            $con = new PDO($dsn, self::$username, self::$password);
            return $con;

        }catch(PDOExcption $e){
            echo "connection failed: " . $e->getMessage();
        }
    }
}
