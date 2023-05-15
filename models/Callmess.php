<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 31.05.2018
 * Time: 21:11
 */

class Callmess {
    public static function addNewMessage($internal, $text, $from){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("
INSERT INTO tp_callmess (to_user,from_user,text,date_time)
VALUES (
:to_user,
:fromus,
 :text,
 NOW()
 )");

        $stmt -> execute(array(
            'to_user' => $internal,
            'fromus' => $from,
            'text'=>$text
        ));

        $oid = $db->lastInsertId ();

        return $oid;
    }

    public static function getNewMessages($login){
        $db = Db::getConection();
        $list = array();

        $res = $db->prepare("
              SELECT *
			  FROM `tp_callmess`
			  WHERE `to_user` = :login
			  AND `stan` = 'new'
			  ");
        $res->execute(array(
            'login'=>$login
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }

    public static function getAllMessages($login){
        $db = Db::getConection();
        $list = array();

        $res = $db->prepare("
              SELECT *
			  FROM `tp_callmess`
			  WHERE `stan` != 'deleted'
			  AND (`to_user` = :login
			  OR `from_user` = :login)
			  ORDER BY `tp_callmess`.`date_time` DESC
			  ");
        $res->execute(array(
            'login'=>$login
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }
        return $list;
    }

    public static function updateNewToRead($login){
        $db = Db::getConection();

        $res = $db->prepare("
UPDATE `tp_callmess`
SET `stan`='read'
WHERE `stan`='new'
AND `to_user` = :login
			  ");
        $answer = $res->execute(array(
            'login'=>$login
        ));
        return $answer;
    }
}