<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 18.04.2016
 * Time: 14:50
 */

class Progression {
    public static function setProgression($oid,$pole,$value){

        $db = Db::getConection();
$res = $db->prepare("
SELECT * FROM `progression` WHERE `oid`=:oid AND `pole`=:pole
");
        $res->execute(array(
            'oid'=>$oid,
            'pole' => $pole
        ));
        if($res->fetch()==null){
            $stmt = $db->prepare("INSERT INTO `progression` (`oid`, `pole`,`sequence`) VALUES (:id, :pole, :val)");
        }else{
            $stmt = $db->prepare('UPDATE `progression` SET `sequence`=:val WHERE `oid`=:id AND `pole`=:pole');
        }

        $res = $stmt -> execute(array(
            'id' => $oid,
            'pole' => $pole,
            'val' => $value
        ));
    }

    public static function getProgressionsByOid($oid){
        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `progression` WHERE `oid` = ?');
        $res->execute(array($oid));
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

}


