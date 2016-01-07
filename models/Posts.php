<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 01.12.2015
 * Time: 11:58
 */

class Posts {
    public static function getPosts(){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `posts`');
        $res->execute();

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $posts[$row['id']] = $row['list'];
        }

        return $posts;

    }

} 