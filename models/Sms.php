<?php

class Sms {

    public static function send($to,$text){
/*$to = $_POST['phone'];
$text = $_POST['message'];
$oid = $_POST['oid'];
$from = 'GaleryMebel';*/
        $textc = urlencode ($text);
        $body=file_get_contents("http://sms.ru/sms/send?api_id=".API_ID."&to=".$to."&text=".$textc);
        return $body;
    }

    public static function save($oid, $text){

        $db = Db::getConection();
        $stmt = $db->prepare("
INSERT INTO `bdgm`.`message` (
    `oid`,
    `date_mes`,
    `time_mes` ,
    `mes`)
VALUES (
    ':oid',
    CURDATE(),
    CURTIME(),
    ':text')
");
        $stmt -> execute(array(
            ':oid' => $oid,
            ':text'=> $text
        ));
    }

    public static function getSamples(){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare('SELECT * FROM `sample_sms`');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[$row['id']] = $row;
        }
        return $list;
    }


} 