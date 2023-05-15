<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 26.07.2016
 * Time: 14:14
 */

class Last_gen {
    public static function getLast($key){

        $db = Db::getConection();

        $res = $db->prepare('SELECT `val` FROM `last_gen` WHERE `key` = ?');
        $res->execute(array($key));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }

} 