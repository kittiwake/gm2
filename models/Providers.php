<?php
/**
 * Created by PhpStorm.
 * User: kitti
 * Date: 29.01.19
 * Time: 14:49
 */

class Providers
{
    public static function getAllProviders(){
        $db = Db::getConection();
        $provList = array();
        $res = $db->prepare('SELECT * FROM `providers`' );
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $provList[$row['id']]['name'] = $row['provider'];
            $provList[$row['id']]['address'] = $row['address'];
        }
        return $provList;
    }
    
    public static function getActiveProviders(){
        $db = Db::getConection();
        $provList = array();
        $res = $db->prepare("SELECT * FROM `providers` WHERE `activity` = '1' ORDER BY `provider` ASC" );
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $provList[$row['id']] = $row['provider'];
        }
        return $provList;
    }
    
    public static function updateParam($id, $pole, $val){
        $db = Db::getConection();
            $res = $db->prepare("
UPDATE `providers` SET `" . $pole . "`=:pre WHERE `id`=:pid");
            $answ = $res->execute(array(
                ':pre' => $val,
                ':pid' => $id
            ));

        return $answ;
    }

}