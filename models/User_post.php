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

    public static function getUsersByUID($uid){

        $db = Db::getConection();

        $userList = array();

        $res = $db->prepare('SELECT * FROM `us_post` WHERE `uid` = :val');
        $res->execute(array(
            ':val'=>$uid));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $userList[] = $row;
        }

        return $userList;

    }

    public static function add($uid,$pid){

        $db = Db::getConection();

        $stmt = $db->prepare("
INSERT INTO  us_post (uid, pid)
VALUES (:uid, :pid)
");
        $res = $stmt -> execute(array(
            'uid'=>$uid,
            'pid'=>$pid
        ));
        return $res;
    }

    public static function del($uid,$pid){

        $db = Db::getConection();

        $stmt = $db->prepare("DELETE FROM `us_post` WHERE `uid` = :uid AND `pid` = :pid");

        $res = $stmt -> execute(array(
            ':uid'=>$uid,
            ':pid'=>$pid
        ));

        return $res;
    }

    public static function addNewWorker($name, $phone, $pid){
        $db = Db::getConection();
            //start transaction
            $db->beginTransaction();
            $stmt = $db->prepare("
            INSERT INTO users (
                name,
                tel,
                user_right,
                validation,
                operative
            )
            VALUES (
                :name,
                :tel,
                :user_right,
                1,
                1
            )
        ");

            $stmt -> execute(array(
                'name'      =>$name,
                'tel'       =>$phone,
                'user_right'=>$pid
            ));

            $uid = $db->lastInsertId ();

            $stmt2 = $db -> prepare("
            INSERT INTO us_post (
                uid,
                pid
            )
            VALUES (
                :uid,
                :pid
            )
        ");
            $stmt2 -> execute(array(
                ':uid' => $uid,
                ':pid' => $pid
            ));

            if($db->commit()){
                return $uid;
            };
    }

} 