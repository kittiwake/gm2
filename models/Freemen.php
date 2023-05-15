<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 28.12.2015
 * Time: 17:06
 */

class Freemen {

    public static function getFreemen($date){

        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `freemen` WHERE `date` = :val');
        $res->execute(array(':val'=>$date));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row['uid'];
        }

        return $list;

    }

    public static function getFreeday($uid){

        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `freemen` WHERE `uid` = :val');
        $res->execute(array(':val'=>$uid));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row['date'];
        }

        return $list;

    }

    public static function getFreeDays(){

        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `freemen` WHERE `date` >= CURDATE() ORDER BY `date`');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;

    }

    public static function addFree($uid, $date){

        $db = Db::getConection();

        $stmt = $db->prepare("INSERT INTO freemen (uid, date) VALUES (:uid, :date)");

        $res = $stmt -> execute(array(
            'uid' => $uid,
            'date'=> $date
        ));

        return $res;
    }

    public static function dellFree($uid, $date){

        $db = Db::getConection();

        $stmt = $db->prepare("DELETE FROM `freemen` WHERE `uid` = :uid AND `date` = :date");

        $res = $stmt -> execute(array(
            'uid' => $uid,
            'date'=> $date
        ));

        return $res;
    }

} 