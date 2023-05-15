<?php

class Clients {

    public static function getClientById($id){
        $db = Db::getConection();

        $res = $db->prepare("
SELECT *
FROM `tp_clients`
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

    public static function getAllClients(){
        $db = Db::getConection();

        $list = array();
        $res = $db->prepare("
SELECT *
FROM `tp_clients`
ORDER BY `name`
");
        $res->execute();
//        $empty = $res->rowCount() === 0;
//        if ($empty) return false;

        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function getLeadClients(){
        $db = Db::getConection();

        $list = array();
        $res = $db->prepare("
SELECT *
FROM `tp_clients`
WHERE `stan`='lead'
ORDER BY `name`
");
        $res->execute();
//        $empty = $res->rowCount() === 0;
//        if ($empty) return false;

        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function getClientByPhone($phone){
        $db = Db::getConection();

        $res = $db->prepare("
SELECT *
FROM `tp_clients`
WHERE `phone`= :phone
or `phone2`= :phone
or `phone3`=:phone
");
        $res->execute(array(
            ':phone'=>$phone
        ));
//        $empty = $res->rowCount() === 0;
//        if ($empty) return false;


        $res->setFetchMode(PDO::FETCH_ASSOC);
        return $res->fetch();
    }

    public static function getClientsLikePhone($phone){
        $db = Db::getConection();

        $list = array();
        $res = $db->prepare("
SELECT *
FROM `tp_clients`
WHERE `phone`LIKE :phone
or `phone2`LIKE :phone
or `phone3`LIKE :phone
");
        $res->execute(array(
            ':phone'=>'%'.$phone.'%'
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function getClientsLikeName($name){
        $db = Db::getConection();
        $orderList = array();
        $res = $db->prepare("
SELECT *
FROM `tp_clients`
WHERE `name` LIKE :name
");
        $res->execute(array(
            ':name'=>'%'.$name.'%'
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }

        return $orderList;
    }

    public static function addClient($phone){
        $db = Db::getConection();

        $res = $db->prepare("
INSERT INTO `tp_clients`(`phone`,`date`,`time`) VALUES (:phone,CURDATE(),CURTIME())
        ");
        $res->execute(array(
            ':phone'=>$phone
        ));
        $custid = $db->lastInsertId ();

        return $custid;
    }

    public static function addClientHand($name,$phone,$phone2,$phone3,$email,$callmen){
        $db = Db::getConection();

        $res = $db->prepare("
INSERT INTO `tp_clients`(`name`,`phone`,`phone2`,`phone3`,`date`,`time`,`email`,`callmen`)
VALUES (:name,:phone,:phone2,:phone3,CURDATE(),CURTIME(),:email,:callmen)
        ");
        $res->execute(array(
            ':name'=>$name,
            ':phone'=>$phone,
            ':phone2'=>$phone2,
            ':phone3'=>$phone3,
            ':email'=>$email,
            ':callmen'=>$callmen
        ));
        $custid = $db->lastInsertId ();

        return $custid;
    }

    public static function delClientById($id){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `tp_clients` WHERE `id` = ?');
        $answ = $res->execute(array($id));

        return $answ;

    }


    public static function updateParam($id, $pole, $value){
        $db = Db::getConection();

        $res = $db->prepare("
UPDATE `tp_clients` SET `" . $pole . "`=:val WHERE `id`=:oid
");
        $answer = $res->execute(array(
            ':val'=>$value,
            ':oid'=>$id
        ));

        return $answer;
    }

}
