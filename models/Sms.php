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

    public static function save($oid, $text, $type='sms'){

        $db = Db::getConection();
        $stmt = $db->prepare("
INSERT INTO `message` (
    `oid`,
    `date_mes`,
    `time_mes` ,
    `mes`,
    `type`)
VALUES (
    :oid,
    CURDATE(),
    CURTIME(),
    :text,
    :type
    )
");
        $stmt -> execute(array(
            ':oid' => $oid,
            ':text'=> $text,
            ':type'=> $type
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

    public static function getSmsByPeriod($dataot, $datapo){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
		SELECT `date_mes`,`time_mes`, `mes`,`type`,
			(SELECT `contract` FROM `orders` WHERE `message`.`oid` = `orders`. `id`) AS `contract`
		FROM `message`
		WHERE  `date_mes` BETWEEN :dataot
		AND :datapo
		ORDER BY `date_mes`
');
        $res->execute(array(
            ':dataot'=>date('Y-m-d', strtotime($dataot)),
            ':datapo'=>date('Y-m-d', strtotime($datapo))
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }
    public static function delOrderByOid($oid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `message` WHERE `oid` = ?');
        $answ = $res->execute(array($oid));

        return $answ;

    }

    public static function sendEmail($to,$subject,$text)
    {
//        if (mail("kittiwake@mail.ru", "the subject", "Example message",
//            "From: manager@kittishop.pw \r\n")) {
//            echo "messege acepted for delivery";
//        } else {
//            echo "some error happen";
//        }
        $message = '
<html>
    <head>
        <title>'.$subject.'</title>
    </head>
    <body>
        <p>'.$text.'</p>
        <p>С уважением, коллектив ООО &#171;Галерая мебели&#187;</p>
    </body>
</html>';

        $headers  = "Content-type: text/html; charset=UTF-8 \r\n";
        $headers .= "From: ООО Галерея мебели<support@galery-mebel.ru>\r\n";
        $headers .= "Reply-To: support@galery-mebel.ru\r\n";//куда слать ответ получателя

        return mail($to, $subject, $message, $headers);
//        return $message;
    }

} 