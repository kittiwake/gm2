<?php

class OrderStan {

    public static function getOrdersByPeriod($begin,$end,$pole='plan'){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `order_stan` WHERE `'.$pole.'` BETWEEN ? AND ?');
        $res->execute(array($begin,$end));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
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
        }

        return $orderList;

    }

    public static function getOrdersFromToday($begin, $end, $oderby){

        $db = Db::getConection();

        $orderList = array();


//        SELECT
//`orders`.`id`,
//`orders`.`contract`,
//`orders`.`term`,
//`plan`,
//`users`.`name` as `tech`,
//`tech_end`,
//`mater`,
//`upak_end`
//FROM `orders`,`order_stan`,`users`
//WHERE `orders`.`id`=`order_stan`.`oid`
//        AND `users`.`id`=`orders`.`technologist`
//        AND `order_stan`.`plan` BETWEEN '2018-01-08' AND '2018-01-20'


        $str = "SELECT
`orders`.`id`,
`orders`.`contract`,
`orders`.`term`,
`plan`,
`orders`.`technologist`,
`orders`.`designer`,
`tech_end`,
`mater`,
`raspil`,
`cpu`,
`gnutje`,
`kromka`,
`krivolin`,
`pris_end`,
`emal`,
`pvh`,
`shpon`,
`photo`,
`pesok`,
`oracal`,
`steklo`,
`fas`,
`vitrag`,
`upak_end`
FROM `orders`,`order_stan`
WHERE `orders`.`id`=`order_stan`.`oid`
AND `order_stan`.`plan` BETWEEN :datebegin AND :datend
ORDER BY `" . $oderby . "` ASC";
        $res = $db->prepare($str);
        $res->execute(array(
            ':datend'=>$end,
            ':datebegin'=>$begin
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
   //         $orderList[$i]['plan'] = $row['plan'];
        }
        return $orderList;
    }

    public static function getReportFromToday(){

        $db = Db::getConection();

        $orderList = array();


       $str = "SELECT `contract` , `plan` , `sum`, `tech_end`
        FROM `order_stan` , `orders`
        WHERE `orders`.`id` = `order_stan`.`oid`
        AND `otgruz_end` ='0'
        AND `plan` >= current_date";

        $res = $db->prepare($str);
        $res->execute();

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function delOrderByOid($oid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `order_stan` WHERE `oid` = ?');
        $answ = $res->execute(array($oid));

        return $answ;

    }

    public static function getNeVipoln($pole_date,$pole_end){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT *
FROM `order_stan`
WHERE `'.$pole_date.'` < CURRENT_DATE
AND `'.$pole_date.'` != \'0000-00-00\'
AND `'.$pole_end.'`=\'0\'
AND `otgruz_end`!=\'2\'
');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['oid']] = $row;
        }

        return $orderList;
    }
    public static function getNeVipoln1($pole_date,$pole_end){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT
`oid`,
`contract`
FROM `orders`,`order_stan`
WHERE `order_stan`.`oid`=`orders`.`id`
AND `'.$pole_date.'`<CURRENT_DATE
AND `'.$pole_date.'`!=\'0000-00-00\'
AND `'.$pole_end.'`=0
AND `otgruz_end`=0;
');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['oid']] = $row;
            //порядок
            $progr = Progression::getProgressionsByOid($row['oid']);
        }

        return $orderList;
    }

    public static function getNeVipolnEtap($pole_date,$pole_end){

        $db = Db::getConection();
        $orderList = array();

        $res = $db->prepare('
SELECT *
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND `'.$pole_date.'` <= CURRENT_DATE
AND `'.$pole_date.'` != \'0000-00-00\'
AND `'.$pole_end.'`=\'0\'
AND `otgruz_end`!=\'2\'
ORDER BY `plan`
');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getPlanToday($pole_date,$pole_end){

        $db = Db::getConection();
        $orderList = array();

        $res = $db->prepare('
SELECT *
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND `'.$pole_date.'` != \'0000-00-00\'
AND ((`'.$pole_date.'` <= CURRENT_DATE
    AND `'.$pole_end.'`=\'0\')
OR (`'.$pole_date.'` = CURRENT_DATE
    AND `'.$pole_end.'`!=\'1\'))
AND `otgruz_end`!=\'2\'
ORDER BY `plan`
');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getPlanOtgruz($date){

        $db = Db::getConection();
        $orderList = array();

        $res = $db->prepare('
SELECT `oid`,`contract`
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND `order_stan`.`plan` = :val
ORDER BY `contract`
');
        $res->execute(array(
            ':val' => $date
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getStanString($oid, $mass){//замменить предыдущую
//$mass - массив полей, необходимых в запросе
        $db = Db::getConection();

        $str = '';
        foreach($mass as $pole){
            $str = $str . '`' . $pole . '`,';
        }
        $str = substr($str, 0, -1);
        $strprep = '
SELECT CONCAT('.$str.
            ') AS `stan`
FROM `order_stan`
WHERE `oid` = :val
';
        $res = $db->prepare($strprep);
        $res->execute(array(':val'=>$oid));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
//return $strprep;
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
SELECT `oid`, `contract`, `sum`, `tech_date`, `plan`
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

    public static function getNotEndForDis($disid){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT `oid`, `contract`, `sum`, `tech_end`, `upak_end`, `otgruz_end`
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND  `sborka_end` = \'0\'
AND `designer` = :val2
ORDER BY `contract`
');
        $res->execute(array(
            ':val2'=>$disid
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getDisEnd($disid){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT `oid`, `contract`, `sum`, `sborka_end_date`
FROM `order_stan`,`orders`
WHERE `order_stan`.`oid` = `orders`.`id`
AND  `sborka_end` = \'2\'
AND `designer` = :val2
AND `sborka_end_date` >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)
ORDER BY `sborka_end_date` DESC
');
        $res->execute(array(
            ':val2'=>$disid
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getNeSobr($coll){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("
SELECT *
FROM `order_stan`,`orders`,`mounting`
WHERE `order_stan`.`oid` = `orders`.`id`
AND `mounting`.`oid` = `orders`.`id`
AND  `sborka_end` = '0'
AND `mounting`.`uid` = :val2
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

        $stmt2 = $db -> prepare("INSERT INTO order_stan (oid, plan, pre_plan) VALUES (:oid, :plan, :plan) ");
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

    public static function updatePlanAsPreplan($oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `order_stan` SET `plan`=`pre_plan` WHERE `oid`=:oid');
        $answer = $res->execute(array(
            ':oid'=>$oid
        ));

        return $answer;
    }

    public static function getRaspilMaterials($begin, $end){
//выбрать количество распиленого материала за период

        $db = Db::getConection();

        $orderList = array();

        $str = "SELECT 
`orders`.`id`, 
`orders`.`contract`, 
`order_stan`.`raspil_date`, 
`bossnotes`.`noteboss` 
FROM `order_stan`, `bossnotes`,`orders` 
WHERE `orders`.`id`=`order_stan`.`oid` 
AND `bossnotes`.`oid`=`order_stan`.`oid` 
AND `order_stan`.`raspil`= '2' 
AND `order_stan`.`raspil_date` BETWEEN :datebegin AND :datend 
AND `bossnotes`.`pole`='mater' 
ORDER BY `order_stan`.`raspil_date` ASC 
        ";
        $res = $db->prepare($str);
        $res->execute(array(
            ':datend'=>date('Y-m-d', strtotime($end)),
            ':datebegin'=>date('Y-m-d', strtotime($begin))
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }
} 
