<?php

class StaticConnection
{    
    private static $host='127.0.0.1';
    private static $db = 'blog_recipes';
    private static $username = 'krok';
    private static $password = '123123123';
     
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