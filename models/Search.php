<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 15.10.17
 * Time: 23:38
 */

class Search
{
    public static function getSearch($search_q)
    {

        $db = Db::getConnection();
        $sql = "SELECT * FROM blogs WHERE title OR content LIKE '%$search_q%'";
        $result = $db->prepare($sql);
        $result->execute();

        $records = $result->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }
}