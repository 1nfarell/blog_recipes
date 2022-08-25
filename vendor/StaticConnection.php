<?php

class StaticConnection
{    
    private static $host='127.0.0.1';
    private static $db = 'database';
    private static $username = 'root';
    private static $password = 'root';
     
    public static function getConnection (): ?PDO
    { 
        $connect = null;        

        $con = "mysql:dbname=".self::$db.";host=".self::$host.";port=3306";
        try
        {
            $connect = new PDO($con, self::$username, self::$password);
        }
        catch(Exception $e)
        {  
            var_dump($e);
        }
        return $connect;
    }    
}    