<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 01.12.2015
 * Time: 18:00
 */

class User_post {
    public static function getUsersByPost($post){

        $db = Db::getConection();

        $userList = array();

        $res = $db->prepare('SELECT * FROM `us_post` WHERE `pid` = :val');
        $res->execute(array(
            ':val'=>$post));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $res->fetch()){
            $userList[$i] = $row;
            $i++;
        }

        return $userList;

    }

    public static function add($uid,$pid){

        $db = Db::getConection();

        $stmt = $db->prepare("INSERT INTO  us_post (uid, pid)
VALUES (:uid, :pid)");

        $res = $stmt -> execute(array(
            ':uid'=>$uid,
            ':pid'=>$pid
        ));

        return $res;
    }

} 