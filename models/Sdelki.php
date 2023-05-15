<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 09.06.2018
 * Time: 13:53
 */

class Sdelki {

    public static function getSdelkiLikeParam($pole,$val){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `crm_sdelki` WHERE `'.$pole.'` LIKE :val');
        $res->execute(array(
            ':val'=>'%'.$val.'%'));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function getLastContracts(){
        $db = Db::getConection();
        $list = array();

        $res = $db->prepare("SELECT `nomer` FROM `crm_sdelki` ORDER BY `id`  DESC LIMIT 10");
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row['nomer'];
        }

        return $list;
    }

    public static function getSdelkaById($id){
        $db = Db::getConection();

        $res = $db->prepare("
SELECT *
FROM `crm_sdelki`
WHERE `id`= :id
");
        $res->execute(array(
            ':id'=>$id
        ));
//        $empty = $res->rowCount() === 0;
//        if ($empty) return false;

        $res->setFetchMode(PDO::FETCH_ASSOC);
        return $res->fetch();
    }

} 