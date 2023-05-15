<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 03.11.2015
 * Time: 10:54
 */

class Users {

    //operative - нужно полностью вывести из кода

    public static function getUsersByParam($param, $val){

        $db = Db::getConection();

        $userList = array();

        $res = $db->prepare('SELECT * FROM `users` WHERE `'.$param.'` = :val');
        $res->execute(array(
            ':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;

        while ($row = $res->fetch()){

            $userList[$i] = $row;
            $i++;
        }

        return $userList;

    }

    public static function getAllUsersNames(){

        $db = Db::getConection();

        $userList = array();

        $res = $db->prepare('SELECT `name` FROM `users`');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $userList[] = $row;
        }
        return $userList;
    }

    public static function getUserById($uid){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `users` WHERE `id` = :val');
        $res->execute(array(
            ':val'=>$uid));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function getUserByInternal($int){

        $db = Db::getConection();

        $res = $db->prepare("SELECT * FROM `users` WHERE `internal` = :val AND `validation` = '1'");
        $res->execute(array(
            ':val'=>$int));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function updateUsersByParam($pole, $val, $oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `users` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }

    public static function getUserByPost($post){

        $db = Db::getConection();

        $res = $db->prepare('
SELECT `id`, `name`, `tel`,`validation`
FROM `users`, `us_post`
WHERE `pid` = :val
AND `users`.`id` = `us_post`.`uid`
');
        $res->execute(array(
            ':val'=>$post));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $userList[] = $row;
        }

        return $userList;
    }

    public static function addUserName($name, $ur){

        $db = Db::getConection();

        $stmt = $db->prepare("
INSERT INTO users (name, validation, user_right)
VALUES (:name, '1', :ur)
");

        $stmt -> execute(array(
            'name' => $name,
            'ur'=>$ur
        ));

        $oid = $db->lastInsertId ();

        return $oid;
    }

}