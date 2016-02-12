<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 04.11.2015
 * Time: 16:48
 */

class OrderStan {

    public static function getOrdersByPeriod($begin,$end,$pole='plan'){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `order_stan` WHERE `'.$pole.'` BETWEEN ? AND ?');
        $res->execute(array($begin,$end));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $res->fetch()){
            $orderList[$i]['oid'] = $row['oid'];
            $orderList[$i]['plan'] = $row['plan'];
            $orderList[$i]['tech_end'] = $row['tech_end'];
            $orderList[$i]['upak_end'] = $row['upak_end'];
            $orderList[$i]['otgruz_end'] = $row['otgruz_end'];
            $orderList[$i]['sborka_end_date'] = $row['sborka_end_date'];
            $i++;
        }

        return $orderList;

    }

    public static function getOrdersByPole($pole,$val){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `order_stan` WHERE `'.$pole.'` = :val');
        $res->execute(array(':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['oid']] = $row;
   //         $orderList[$i]['plan'] = $row['plan'];
        }

        return $orderList;

    }

    public static function getSobr($sbend,$coll){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT *
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND  `sborka_end` = :val1
AND `collector` = :val2
AND `sborka_end_date`>= (CURDATE( ) - INTERVAL 1 MONTH ) ');
        $res->execute(array(
            ':val1'=>$sbend,
            ':val2'=>$coll
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['oid']] = $row;
        }
        return $orderList;
    }

    public static function getTechEnd($tech){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT `oid`, `contract`, `sum`, `tech_date`
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND  `tech_end` = \'2\'
AND `technologist` = :val2
AND (
  (
    MONTH(`tech_date`) = MONTH(CURRENT_DATE)
    AND YEAR(`tech_date`) = YEAR(CURRENT_DATE)
  )
  OR (
    MONTH(`tech_date`) = MONTH(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))
    AND YEAR(`tech_date`) = YEAR(DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH))
  )
)
ORDER BY `tech_date` DESC
');
        $res->execute(array(
            ':val2'=>$tech
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['oid']] = $row;
        }
        return $orderList;
    }

    public static function getTechNotEnd($tech){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT `oid`, `contract`, `sum`, `tech_date`
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND  `tech_end` = \'0\'
AND `tech_date` != \'0000-00-00\'
AND `technologist` = :val2
ORDER BY `tech_date` DESC
');
        $res->execute(array(
            ':val2'=>$tech
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['tech_date']][] = $row;
        }
        return $orderList;
    }


    public static function getNeSobr($coll){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("
SELECT *
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND  `sborka_end` = '0'
AND `collector` = :val2
");
        $res->execute(array(
            ':val2'=>$coll
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['oid']] = $row;
        }

        return $orderList;

    }
    public static function add($oid,$term){

        $db = Db::getConection();

        $stmt2 = $db -> prepare("INSERT INTO order_stan (oid, plan) VALUES (:oid, :plan) ");
        $stmt2 -> execute(array(
            ':oid' => $oid,
            ':plan' => $term
        ));
    }


    public static function updateStanByParam($pole, $val, $oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `order_stan` SET `' . $pole . '`=:val WHERE `oid`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }

} 