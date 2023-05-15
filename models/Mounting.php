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
    public static function getMountByOidDate($oid, $datedb)
    {
        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `mounting` WHERE `oid` = :oid AND `m_date` = :date');
        $res->execute(array(
            ':oid' => $oid,
            ':date' => $datedb
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()) {
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getMountingsByUid($uid)
    {
        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT `mounting`.`oid` , `sborka_end` , `sborka_end_date` , `name`, `uid` , `m_date`, `contract`,`sum`,`beznal`,`adress`,`phone`,`sumcollect`,`designer`,`technologist`
FROM `mounting` , `order_stan`, `orders`
WHERE `uid` = :uid
AND `mounting`.`oid` = `order_stan`.`oid`
AND `mounting`.`oid` = `orders`.`id`
ORDER BY `m_date`
');
        $res->execute(array(
            ':uid' => $uid
        ));
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

    public static function updateMountingUid($oid, $uid, $datedb, $newuid = ''){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `mounting` SET `uid`= :newuid WHERE `oid`=:oid AND `m_date`=:valf AND `uid`=:val');
        $answer = $res->execute(array(
            ':val'=>$uid,
            ':newuid'=>$newuid,
            ':oid'=>$oid,
            ':valf'=>$datedb
        ));

        return $answer;
    }
    public static function updateMountingTarget($oid, $datedb, $target){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `mounting` SET `target`= :target WHERE `oid`=:oid AND `m_date`=:valf');
        $answer = $res->execute(array(
            ':target'=>$target,
            ':oid'=>$oid,
            ':valf'=>$datedb
        ));

        return $answer;
    }

    public static function getMountingLast($oid){

        $db = Db::getConection();
        $montList = array();
        $res = $db->prepare('SELECT *
FROM `mounting`
WHERE `oid` =?
AND `target`=\'assembly\'
AND `m_date` = (
SELECT MAX( m_date )
FROM `mounting`
WHERE `oid` =? )');
        $res->execute(array($oid,$oid));

        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()) {
            $montList[] = $row;
        }
        return $montList;
    }

    public static function getMeasureLast($oid){

        $db = Db::getConection();
        $montList = array();
        $res = $db->prepare('SELECT *
FROM `mounting`
WHERE `oid` =?
AND `target`=\'measure\'
AND `m_date` = (
SELECT MAX( m_date )
FROM `mounting`
WHERE `oid` =? )');
        $res->execute(array($oid,$oid));

        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()) {
            $montList[] = $row;
        }
        return $montList;
    }

    public static function addMounting($oid, $uid, $datedb, $target='assembly'){

        $db = Db::getConection();

        $res = $db->prepare('INSERT INTO `mounting`(`oid`,`uid`,`m_date`,`target`) VALUES (:oid, :uid, :date, :target)');
        $answer = $res->execute(array(
            ':oid'=>$oid,
            ':uid'=>$uid,
            ':target'=>$target,
            ':date'=>$datedb
        ));
        return $answer;
    }

    public static function delMounting($oid, $uid, $datedb){
        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `mounting` WHERE `oid`=:oid AND `m_date`=:date AND `uid`=:uid');
        $answer = $res->execute(array(
            ':oid'=>$oid,
            ':uid'=>$uid,
            ':date'=>$datedb
        ));

    }
    public static function delOrderByOid($oid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `mounting` WHERE `oid` = ?');
        $answ = $res->execute(array($oid));

        return $answ;

    }





}