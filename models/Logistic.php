<?php

class Logistic {

    public static function add($date,$type,$point,$address,$summ,$note){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("INSERT INTO logistic (`date`,`type`,`point`,`address`,`summ`,`note`)
VALUES (:date, :type, :point, :address, :summ, :note)");
        $str = "INSERT INTO logistic (`date`,`type`,`point`,`address`,`summ`,`note`)
VALUES ($date, $type, $point, $address, $summ, $note)";

        $stmt -> execute(array(
            'date'=>$date,
            'type'=>$type,
            'point'=>$point,
            'address'=>$address,
            'summ'=>$summ,
            'note'=>$note
        ));

        $oid = $db->lastInsertId ();

        return $oid;
    }

    public static function getLogistsByParam($param, $val){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `logistic` WHERE `'.$param.'` = :val');
        $res->execute(array(
            ':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $orderList[] = $row;
        }

        return $orderList;

    }
    public static function getLogistBy2Param($param1, $val1, $param2, $val2){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `logistic` WHERE `'.$param1.'` = :val1 AND `'.$param2.'` = :val2 and `type`=:out');
        $res->execute(array(
            ':val1'=>$val1,
            ':val2'=>$val2,
            ':out'=>'in',
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function getLogistInBy2Dates($begin, $end){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("SELECT * FROM `logistic` WHERE `date` BETWEEN :val1 AND :val2 AND `type`='in'");
        $res->execute(array(
            ':val1'=>$begin,
            ':val2'=>$end
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $orderList[] = $row;
        }

        return $orderList;

    }

    public static function getOrdersToDriver($driver){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("
SELECT `logistic`.`point`,`orders`.`contract`
FROM `logistic`,`orders`
WHERE `logistic`.`point`=`orders`.`id`
AND `logistic`.`date`=CURRENT_DATE
AND `logistic`.`driver`=:driver
AND `logistic`.`type`='out'
");
        $res->execute(array(
            ':driver'=>$driver));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){

            $orderList[] = $row;
        }

        return $orderList;

    }

    public static function getLogistForMaterial($date, $point, $type = 'auto'){

        $db = Db::getConection();

        $res = $db->prepare("
SELECT *
FROM `logistic`
WHERE `logistic`.`point`= :point
AND `logistic`.`date`= :dbdate
AND `logistic`.`type`= :logtype
");
        $res->execute(array(
            ':point'=>$point,
            ':dbdate'=>$date,
            ':logtype'=>$type
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }

    public static function delLogistById($id){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `logistic` WHERE `id` = ?');
        $answ = $res->execute(array($id));

        return $answ;

    }

    public static function updateLogistByParam($pole, $val, $lid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `logistic` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$lid
        ));

        return $answer;
    }

    public static function updateLogistSumm($deltaval, $lid, $add=1){

        $db = Db::getConection();
        if($add == 1){
            $res = $db->prepare('UPDATE `logistic` SET `summ`=`summ`+:val WHERE `id`=:oid');
        }
        else{
            $res = $db->prepare('UPDATE `logistic` SET `summ`=`summ`-:val WHERE `id`=:oid');
        }

        $answer = $res->execute(array(
            ':val'=>$deltaval,
            ':oid'=>$lid
        ));

        return $answer;
    }


} 