<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 03.12.2015
 * Time: 18:01
 */

class Dillers {
    public static function getDillersByParam($param, $val){

        $db = Db::getConection();

        $userList = array();

        $res = $db->prepare('SELECT * FROM `dillers` WHERE `'.$param.'` = :val');
        $res->execute(array(
            ':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $userList[] = $row;
        }

        return $userList;

    }

    public static function getAllDillers(){

        $db = Db::getConection();

        $userList = array();

        $res = $db->prepare('SELECT * FROM `dillers`');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $userList[] = $row;
        }

        return $userList;

    }

} 