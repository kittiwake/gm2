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

    public static function add($contract, $contract_date, $name, $product, $adress, $phone, $term, $designer, $sum, $prepayment, $rassr, $beznal, $note){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("INSERT INTO orders (contract, contract_date, name, product, adress, phone, date, term, designer, sum, prepayment, rassr, beznal)
VALUES (:contract, :contract_date, :name, :product, :adress, :phone, CURDATE(), :term, :designer, :sum, :prepayment, :rassr, :beznal)");

        $term = Datas::checkSunday($term);
        $res1 = $stmt -> execute(array(
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

        $stmt2 = $db -> prepare("INSERT INTO order_stan (oid, plan) VALUES (:oid, :plan) ");
        $res2 = $stmt2 -> execute(array(
            ':oid' => $oid,
            ':plan' => $term
        ));

        if($note != ''){
            $stmt3 = $db -> prepare("INSERT INTO notes (oid, note, date) VALUES (:oid, :note, CURDATE()) ");
            $res3 = $stmt3 -> execute(array(
                ':oid' => $oid,
                ':note' => $note
            ));
        }

        $res = $res1 && $res2;
        return $res;
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


} 