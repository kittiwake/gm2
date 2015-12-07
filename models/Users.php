<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 03.11.2015
 * Time: 10:54
 */

class Users {

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

    public static function updateUsersByParam($pole, $val, $oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `users` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }


} 