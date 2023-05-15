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

    public static function getOrderByIdForPlan($id){

        $db = Db::getConection();


        $res = $db->prepare('
SELECT
`oid`,
`contract`
FROM `orders`,`order_stan`
WHERE `order_stan`.`oid`=`orders`.`id`
AND `kromka_date`<CURRENT_DATE
AND `kromka_date`!=\'0000-00-00\'
AND `kromka`=0
AND `otgruz_end`=0;
        ');
        $res->execute(array($id));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }
    public static function delOrderById($id){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `orders` WHERE `id` = ?');
        $answ = $res->execute(array($id));

        return $answ;

    }

    public static function getOrdersByParam($param, $val){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `orders` WHERE `'.$param.'` = :val');
        $res->execute(array(
            ':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $orderList[] = $row;
        }

        return $orderList;

    }

    public static function getOrdersFromToday(){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("
              SELECT `contract`,`oid`,`plan`,
              (SELECT bossnotes.noteboss FROM bossnotes WHERE bossnotes.oid = orders.id AND bossnotes.pole='mater') AS `mater`
			  FROM `orders`, `order_stan`
			  WHERE `orders`.`id` = `order_stan`.`oid`
			  AND `order_stan`.`plan` >= CURDATE()
			  ");
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $today = strtotime('today');
        while ($row = $res->fetch()){
            $date = strtotime($row['plan']);
            $daysdiff = ($date - $today)/60/60/24;
            $orderList[$daysdiff][] = array(
                'oid' => $row['oid'],
                'con' => $row['contract'],
                'mater' => $row['mater']
            );
        }

        return $orderList;

    }

    public static function getOrdPlansByPeriod($first, $last){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("
              SELECT `contract`,`oid`,`plan`,`tech_end`,`upak_end`,`otgruz_end`
			  FROM `orders`, `order_stan`
			  WHERE `orders`.`id` = `order_stan`.`oid`
			  AND `order_stan`.`plan` BETWEEN :dataot
		AND :datapo
			  ");
        $res->execute(array(
            ':dataot'=>$first,
            ':datapo'=>$last
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;

    }

    public static function getOrdersFromToday1(){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare("
              SELECT `contract`,`oid`,`plan`,
              (SELECT bossnotes.noteboss FROM bossnotes WHERE bossnotes.oid = orders.id AND bossnotes.pole='mater') AS `mater`
			  FROM `orders`, `order_stan`
			  WHERE `orders`.`id` = `order_stan`.`oid`
			  AND `order_stan`.`plan` >= CURDATE()
			  ");
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $today = strtotime('today');
        while ($row = $res->fetch()){
            $date = strtotime($row['plan']);
            $daysdiff = ($date - $today)/60/60/24;
            $orderList[$daysdiff][] = array(
                'oid' => $row['oid'],
                'con' => $row['contract'],
                'mater' => $row['mater']
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
			  AND `orders`.`archive` = \'0\'
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

    public static function add($contract, $contract_date, $name, $product, $adress, $phone, $term, $designer, $sum, $prepayment, $rassr, $beznal,$email,$agreement,$rebate,$sumdeliv,$sumcollect,$ooo){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("INSERT INTO orders (contract, contract_date, name, product, adress, phone, personal_agree, date, term, designer, sum, prepayment, rassr, beznal, email,rebate,sumdeliv,sumcollect,company)
VALUES (:contract, :contract_date, :name, :product, :adress, :phone, :agreement, CURDATE(), :term, :designer, :sum, :prepayment, :rassr, :beznal, :email, :rebate,:sumdeliv,:sumcollect, :ooo)");

        $stmt -> execute(array(
            'contract' => $contract,
            'contract_date'=> Datas::dateToDb($contract_date),
            'name' => $name,
            'product' => $product,
            'adress' => $adress,
            'phone'  => $phone,
            'agreement'  => $agreement,
            'term' => $term,
            'designer' => $designer,
            'sum' => $sum,
            'prepayment' => $prepayment,
            'rassr' => $rassr,
            'beznal' => $beznal,
            'email' => $email,
            'rebate' => $rebate,
            'sumdeliv'=>$sumdeliv,
            'sumcollect'=>$sumcollect,
            'ooo'=> $ooo
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
SELECT `oid`, `contract`, `sum`, (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `technologist`) AS `tech`, `plan`
FROM `orders` , `order_stan`
WHERE `contract` REGEXP \'^.*[РДр][1-9]?$\'
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

    public static function getTechEndByPeriod($dataot, $datapo) {

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
		SELECT `contract`, `sum`, `tech_date`,
		  (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `technologist`) AS `tech`
		FROM `orders`, `order_stan`
		WHERE  `orders`.`id` = `order_stan`.`oid`
		AND `tech_end` = \'2\'
		AND `tech_date` BETWEEN :dataot
		AND :datapo
		ORDER BY `tech_date`
');
        $res->execute(array(
            ':dataot'=>date('Y-m-d', strtotime($dataot)),
            ':datapo'=>date('Y-m-d', strtotime($datapo))
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[$row['tech']][] = $row;
        }
        return $orderList;
    }

    public static function getOtgruzByPeriod($dataot, $datapo) {

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
		SELECT `oid`,`contract`, `sum`, `plan`,`name`,`product`,`adress`,`phone`,
			(SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `technologist`) AS `tech`,
            (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `designer`) AS `dis`
		FROM `orders`, `order_stan`
		WHERE  `orders`.`id` = `order_stan`.`oid`
		AND `otgruz_end` = \'2\'
		AND `plan` BETWEEN :dataot
		AND :datapo
		ORDER BY `plan`
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

    public static function getPlanByPeriod($dataot, $datapo) {

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
		SELECT `oid`,`contract`, `sum`, `plan`,`name`,`product`,`adress`,`phone`,
			(SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `technologist`) AS `tech`,
            (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `designer`) AS `dis`
		FROM `orders`, `order_stan`
		WHERE  `orders`.`id` = `order_stan`.`oid`
		AND `plan` BETWEEN :dataot
		AND :datapo
		ORDER BY `plan`
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

    public static function getInfoAboutOrder($con,$name,$phone,$str,$h,$f){
        $db = Db::getConection();
        $orderList = array();
        if($con!=''||$name!=''||$phone!=''||$str!=''||$h!=''||$f!=''){
        $sqlstr = "
SELECT `oid`, `contract`, `name`, `phone`, `adress`,`contract_date`,`plan`,`term`,
    (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `technologist`) AS `tech`,
    (SELECT `name` FROM `users` WHERE `users`.`id` = `orders`. `designer`) AS `dis`
FROM  `orders`, `order_stan`
WHERE `orders`.`id`=`order_stan`.`oid`
";
        if($con!=''){
            $sqlstr .= "AND `contract` LIKE '%$con%'";
        }
        if($name!=''){
            $sqlstr .= "AND `name` LIKE '%$name%'";
        }
        if($phone!=''){
            $sqlstr .= "AND `phone` LIKE '%$phone%'";
        }
        if($str!=''){
            $sqlstr .= "AND `adress` LIKE '%$str%'";
        }
        if($h!=''){
            $sqlstr .= "AND `adress` LIKE '%$h%'";
        }
        if($f!=''){
            $sqlstr .= "AND `adress` LIKE '%$f%'";
        }

        $res = $db->prepare($sqlstr);
        $res->execute();

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = array($row['oid'],$row['contract'],$row['name'],$row['phone'],$row['adress'],$row['contract_date'],$row['plan'],$row['tech'],$row['dis'],$row['term']);
        }
        }
        return $orderList;

    }

    public static function getClaimsByContract($con){
        $db = Db::getConection();
        $orderList = array();
        if($con!=''){
        $sqlstr = "
SELECT `oid`, `contract`, `sum`
FROM  `orders`, `order_stan`
WHERE `orders`.`id`=`order_stan`.`oid`
AND `contract` LIKE '$con%'
";
        $res = $db->prepare($sqlstr);
        $res->execute();

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        }
        return $orderList;

    }

} 