<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 21.09.17
 * Time: 23:33
 */

class Db
{

    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);


        $dsn = "mysql:host={$params['host']}; dbname={$params['dbname']}; charset=utf8";

        try {
            $db = new PDO ($dsn, $params['user'], $params['password']);
            $db->exec("set names utf8");
        }
        catch (PDOException $e){
            die('Помилка підключення БД :'.$e->getMessage());
        }
        return $db;
    }
}