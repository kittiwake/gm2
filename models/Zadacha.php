<?php

class Zadacha {
    public static function getNewTodo($login='all'){
        $db = Db::getConection();

        if($login=='all'){
            $qwery = "SELECT
`id`,
(SELECT `name` FROM `tp_clients` WHERE `tp_clients`.`id`=`crm_zadacha`.`client`) AS `client`,
(SELECT `nomer` FROM `crm_sdelki` WHERE `crm_sdelki`.`id`=`crm_zadacha`.`sdelka`) AS `sdelka`,
`date`, `time`, `to_user`, `from_user`, `type_zadacha`, `zadacha`, `stan`, `comment`
FROM `crm_zadacha`
WHERE `stan` = 'new'
";
        }
        else{
            $qwery = "SELECT
`id`,
(SELECT `name` FROM `tp_clients` WHERE `tp_clients`.`id`=`crm_zadacha`.`client`) AS `client`,
(SELECT `nomer` FROM `crm_sdelki` WHERE `crm_sdelki`.`id`=`crm_zadacha`.`sdelka`) AS `sdelka`,
`date`, `time`, `to_user`, `from_user`, `type_zadacha`, `zadacha`, `stan`, `comment`
FROM `crm_zadacha`
WHERE `to_user` LIKE :login
AND `stan` = 'new'
";
        }
        $list = array();
        $res = $db->prepare($qwery);
        $res->execute(array('login'=>$login));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function addNewZadacha($datetodo,$timetodo,$from,$touser,$type,$text,$client='',$sdelka=''){

        $db = Db::getConection();

        $res = $db->prepare("
INSERT INTO `crm_zadacha` (
`client`,
`sdelka`,
`date`,
`time`,
`to_user`,
`from_user`,
`type_zadacha`,
`zadacha`
) VALUES (
:client,
:sdelka,
:date,
:time,
:to_user,
:from_user,
:type_zadacha,
:zadacha
);
        ");
        $res->execute(array(
            'client'=>$client,
            'sdelka'=>$sdelka,
            'date'=>$datetodo,
            'time'=>$timetodo,
            'to_user'=>$touser,
            'from_user'=>$from,
            'type_zadacha'=>$type,
            'zadacha'=>$text
        ));

        return $db->lastInsertId();
    }

    public static function updatePole($pole,$val,$id){
        $db = Db::getConection();

        $res = $db->prepare('UPDATE `crm_zadacha` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$id
        ));

        return $answer;

    }

    public static function getTodoById($id){
        $db = Db::getConection();
        $res = $db->prepare("
        SELECT * FROM `crm_zadacha` WHERE `id` = :id
        ");
        $res->execute(array('id'=>$id));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }
} 