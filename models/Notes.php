<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 11.01.2016
 * Time: 17:28
 */

class Notes {

    public static function getNotesByOid($oid){

        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `notes` WHERE `oid` = :val');
        $res->execute(array(':val'=>$oid));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;

    }

    public static function setNote($oid, $note, $use = 'order'){

        $db = Db::getConection();

        $res = $db->prepare("
INSERT INTO `notes` (`oid`, `note` , `date`, `use`)
VALUES (:oid, :note, CURDATE(), :use)
	  ");
        $res->execute(array(
            'oid'=>$oid,
            'note'=>$note,
            'use'=>$use
        ));

    }
    public static function delOrderByOid($oid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `notes` WHERE `oid` = ?');
        $answ = $res->execute(array($oid));

        return $answ;

    }

} 