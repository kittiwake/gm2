<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 16.12.2015
 * Time: 11:31
 */

class Mounting
{

    public static function getMountByPole($pole, $val)
    {
        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `mounting` WHERE `' . $pole . '` = :val');
        $res->execute(array(':val' => $val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()) {
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function updateMountingDate($oid, $date, $fistdata = '0000-00-00'){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `mounting` SET `m_date`=:val WHERE `oid`=:oid AND `m_date`=:valf');
        $answer = $res->execute(array(
            ':val'=>$date,
            ':oid'=>$oid,
            ':valf'=>$fistdata
        ));

        return $answer;
    }

    public static function updateMountingUid($oid, $uid, $fistdata){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `mounting` SET `uid`=:val WHERE `oid`=:oid AND `m_date`=:valf');
        $answer = $res->execute(array(
            ':val'=>$uid,
            ':oid'=>$oid,
            ':valf'=>$fistdata
        ));

        return $answer;
    }

    public static function getMountingLast($oid){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `mounting` WHERE `oid` = ? ORDER BY `m_date`  DESC LIMIT 1');
        $res->execute(array($oid));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function addMounting($oid, $uid, $datedb){

        $db = Db::getConection();

        $res = $db->prepare('INSERT INTO `mounting`(`oid`,`uid`,`m_date`) VALUES (:oid, :uid, :date)');
        $answer = $res->execute(array(
            ':oid'=>$oid,
            ':uid'=>$uid,
            ':date'=>$datedb
        ));
echo $uid;
        return $answer;
    }





}