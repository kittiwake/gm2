<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 12.01.2018
 * Time: 21:37
 */

class Bossnotes {

    public static function getNote($oid,$pole){ //единсвенная запись в БД
        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `bossnotes` WHERE `oid` = :oid AND `pole` = :pole');
        $res->execute(array(
            ':oid'=>$oid,
            ':pole'=>$pole
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function getOrderNotes($oid){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `bossnotes` WHERE `oid` = :oid');
        $res->execute(array(
            ':oid'=>$oid
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }

    public static function delOrderNote($oid,$pole){
        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `bossnotes` WHERE `oid`=:oid AND `pole`=:pole');
        $answ = $res->execute(array(
            ':oid'=>$oid,
            ':pole'=>$pole
        ));
        return $answ;
    }

    public static function addNote($oid,$pole,$note){
        $db = Db::getConection();

        $stmt = $db->prepare("INSERT INTO `bossnotes` (`oid`,`pole`,`noteboss`)
VALUES (:oid, :pole, :note)");

        $stmt -> execute(array(
            ':oid'=>$oid,
            ':pole'=>$pole,
            ':note'=>$note
        ));

        $oid = $db->lastInsertId ();
        return $oid;
    }

    public static function updateNote($id,$note){
        $db = Db::getConection();

        $res = $db->prepare('UPDATE `bossnotes` SET `noteboss`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$note,
            ':oid'=>$id
        ));

        return $answer;
    }

} 