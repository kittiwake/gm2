<?php

class Plan_dis {

    public static function addNew($contract, $adress, $term, $designer, $note,$empt,$name_men){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("INSERT INTO plan_dis (contract, address, date_dis, dis, note, stan, empty,name_men)
VALUES (:contract, :address, :term, :designer, :note, 'new', :empt,:name_men)");

        $stmt -> execute(array(
            ':contract' => $contract,
            ':address'  => $adress,
            ':term'     => Datas::dateToDb($term),
            ':designer' => $designer,
            ':empt'     => $empt,
            ':name_men' => $name_men,
            ':note'     => $note
        ));

        $oid = $db->lastInsertId ();

        return $oid;
    }

    public static function getCurrent(){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `plan_dis` WHERE `stan` = \'tekuch\' OR `stan` = \'new\' OR ( `stan` = \'zakluchen\' AND `render` != \'all\')');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function getSamplesByDis($uid){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `plan_dis` WHERE `dis` = :uid ORDER BY `date_dis`');
        $res->execute(array(
            'uid'=>$uid
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }

    public static function getSamplesByParam($pole, $val){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `plan_dis` WHERE `'.$pole.'` = :uid ORDER BY `date_dis`');
        $res->execute(array(
            'uid'=>$val
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }

    public static function getSamplesByPeriod($begin,$end){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `plan_dis` WHERE `date_dis` BETWEEN :beg AND :end ORDER BY `date_dis`');
        $res->execute(array(
            'beg'=>$begin,
            'end'=>$end
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }

    public static function updateSamplesByParam($pole, $val, $oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `plan_dis` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }

    public static function deleteSample($oid){
        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `plan_dis` WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':oid'=>$oid
        ));
        return $answer;
    }
}