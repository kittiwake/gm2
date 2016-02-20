<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 03.11.2015
 * Time: 13:22
 */

class Order {

    public static function getOrderById($id){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `orders` WHERE `id` = ?');
        $res->execute(array($id));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }

    public static function getOrdersByParam($param, $val){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `orders` WHERE `'.$param.'` = :val');
        $res->execute(array(
            ':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;

        while ($row = $res->fetch()){

            $orderList[$i]['id'] = $row['id'];
            $orderList[$i]['contract'] = $row['contract'];
            $i++;
        }

        return $orderList;

    }

    public static function getOrdersFromToday(){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
              SELECT `contract`,`oid`,`plan`
			  FROM `orders`, `order_stan`
			  WHERE `orders`.`id` = `order_stan`.`oid`
			  AND `order_stan`.`plan` >= CURDATE()
			  ');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $today = strtotime('today');
        while ($row = $res->fetch()){
            $date = strtotime($row['plan']);
            $daysdiff = ($date - $today)/60/60/24;
            $orderList[$daysdiff][] = array(
                'oid' => $row['oid'],
                'con' => $row['contract']
            );
        }

        return $orderList;

    }

    public static function getOrdersLikeParam($param, $val){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `orders` WHERE `'.$param.'` LIKE :val');
        $res->execute(array(
            ':val'=>'%'.$val.'%'));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }

        return $orderList;

    }

    public static function getOrdersNoReckoning(){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
              SELECT `contract`,`oid`, `technologist`, `tech_date`
			  FROM `orders`, `order_stan`
			  WHERE `orders`.`id` = `order_stan`.`oid`
			  AND `order_stan`.`tech_end` = \'0\'
			  AND `order_stan`.`tech_date` != \'0000-00-00\'
			  ');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;

    }

    public static function getOrdersNoaAppointTech(){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
              SELECT `contract`,`oid`, `designer`, `term`, `sum`
			  FROM `orders`, `order_stan`
			  WHERE `orders`.`id` = `order_stan`.`oid`
			  AND `order_stan`.`tech_end` = \'0\'
			  AND `order_stan`.`tech_date` = \'0000-00-00\'
			  AND `order_stan`.`otgruz_end` != \'2\'
			  ORDER BY `plan`
			  ');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;

    }

    public static function add($contract, $contract_date, $name, $product, $adress, $phone, $term, $designer, $sum, $prepayment, $rassr, $beznal){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("INSERT INTO orders (contract, contract_date, name, product, adress, phone, date, term, designer, sum, prepayment, rassr, beznal)
VALUES (:contract, :contract_date, :name, :product, :adress, :phone, CURDATE(), :term, :designer, :sum, :prepayment, :rassr, :beznal)");

        $stmt -> execute(array(
            'contract' => $contract,
            'contract_date'=> Datas::dateToDb($contract_date),
            'name' => $name,
            'product' => $product,
            'adress' => $adress,
            'phone'  => $phone,
            'term' => $term,
            'designer' => $designer,
            'sum' => $sum,
            'prepayment' => $prepayment,
            'rassr' => $rassr,
            'beznal' => $beznal
        ));

        $oid = $db->lastInsertId ();

        return $oid;
    }

    public static function updateOrdersByParam($pole, $val, $oid){

        $db = Db::getConection();
        
        $res = $db->prepare('UPDATE `orders` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }

    public static function getNeRekl($n){

        $db = Db::getConection();

        $res = $db->prepare('
SELECT SUM(sum), COUNT(sum)
FROM `orders` , `order_stan`
WHERE `contract` NOT REGEXP \'^.*[РД][1-9]?$\'
AND `orders`.`id` = `order_stan`.`oid`
AND `order_stan`.`plan`>= DATE_ADD(\'2014-07-01\',INTERVAL :n1 MONTH)
AND `order_stan`.`plan`< DATE_ADD(\'2014-07-01\',INTERVAL :n2 MONTH)
');
        $res->execute(array(
            ':n1'=> $n,
            ':n2'=>  $n+1
    ));
        return $res->fetch();
    }

    public static function getRekl($n){

        $db = Db::getConection();

        $res = $db->prepare('
SELECT COUNT(sum)
FROM `orders` , `order_stan`
WHERE `contract` REGEXP \'^.*[РД][1-9]?$\'
AND `orders`.`id` = `order_stan`.`oid`
AND `order_stan`.`plan`>= DATE_ADD(\'2014-07-01\',INTERVAL :n1 MONTH)
AND `order_stan`.`plan`< DATE_ADD(\'2014-07-01\',INTERVAL :n2 MONTH)
');
        $res->execute(array(
            ':n1'=> $n,
            ':n2'=>  $n+1
    ));

        return $res->fetch();
    }

    public static function getClaimsNoSum() {

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
SELECT `oid`, `contract`, `sum`, (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `technologist`) AS `tech`
FROM `orders` , `order_stan`
WHERE `contract` REGEXP \'^.*[РД][1-9]?$\'
AND `orders`.`id` = `order_stan`.`oid`
AND `orders`.`sum` < 1000
AND `order_stan`.`otgruz_end`!= \'2\'
');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }


} 