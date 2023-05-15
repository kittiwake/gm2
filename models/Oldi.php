<?php


class Oldi {
    
    public static function getOrdersByPeriod($first, $last, $tip){
        
        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('
		SELECT *
		FROM `oldi_orders`,`oldi_stan`
		WHERE  `oldi_stan`.`oid` = `oldi_orders`.`id`
		AND `plan` BETWEEN :dataot
		AND :datapo
		AND `tip` = :tip
		ORDER BY `plan`
');
        $res->execute(array(
            ':dataot'=>$first,
            ':datapo'=>$last,
            ':tip'=>$tip
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }
       
    public static function getOrderById($id){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `oldi_orders` WHERE `id` = ?');
        $res->execute(array($id));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }

    public static function getEtaps ($ri)
    {
        $db = Db::getConection();

        $etapList = array();
        
        $req = 'SELECT * FROM `oldi_etaps` WHERE `visual_'.$ri.'` != 0 ORDER BY `visual_'.$ri.'`';

        $res = $db->prepare($req);

        $res->execute();

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $etapList[$row['visual_'.$ri]]['etap'] = $row['etap'];
            $etapList[$row['visual_'.$ri]]['etap_stan'] = $row['etap_stan'];
            $etapList[$row['visual_'.$ri]]['etap_date'] = $row['etap_date'];
        }

        return $etapList;

    }   
    
    
    public static function getStan($id){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `oldi_stan` WHERE `oid` = :oid');
        $vipoln = $res->execute(array('oid'=>$id));
        $res->setFetchMode(PDO::FETCH_ASSOC);

            return $res->fetch();
    }
    
    public static function getCustomer($id){
        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `customer` WHERE `id` = :id');
        $res->execute(array(
            ':id'=>$id
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }

    public static function getAllDillers(){
        $db = Db::getConection();
        
        $list = array();

        $res = $db->prepare('SELECT * FROM `oldi_customer` WHERE `diller`= 1');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[$row['id']] = $row;
        }
        
        return $list;
    }
    
    public static function getActiveDillers(){
        $db = Db::getConection();
        
        $list = array();

        $res = $db->prepare('SELECT * FROM `oldi_customer` WHERE `diller`= 1 AND `active_dil` = 1 ORDER BY `name`');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[$row['id']] = $row;
        }
        
        return $list;
    }
    
    public static function getNameFile($arr, $dop_ef, $rad, $foto, $pokr){
        $arr = array_slice($arr, 3); // убрали 3 первых эл-та массива - первые 3 поля из таблицы
        $images = array();
        foreach ($arr as $key => $val){
            $images [$key] = $val;
            if ($rad == 0){
                $images['radius'] = 2;
                $images['mat_radius'] = 2;
            }
            if ($foto == 0){
                $images['fotopec'] = 2;
            }
            if ($pokr == 0 || $pokr == 1){
                $images['polir'] = 2;
            }
            if ($dop_ef == 0){
                $images['spef'] = 2;
            }


        }
        return $images;
    }

    public static function checkContractExist ($contract){

        $orderList = array();
        $db = Db::getConection();
     
        $res = $db->prepare('SELECT * FROM `oldi_orders` WHERE `contract` REGEXP \''.$contract.'(\\\\(...\\\\))*$\'');
        $vipoln = $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }
    
    public static function getOrdersByParam($param, $val){

        $db = Db::getConection();

        $orderList = array();

        $res = $db->prepare('SELECT * FROM `oldi_orders` WHERE `'.$param.'` = :val');
        $res->execute(array(
            ':val'=>$val));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){

            $orderList[] = $row;
        }

        return $orderList;

    }

    public static function updateOrderByParam($pole, $val, $oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `oldi_orders` SET `' . $pole . '`=:val WHERE `id`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }
    
    public static function updateStanByParam($pole, $val, $oid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `oldi_stan` SET `' . $pole . '`=:val WHERE `oid`=:oid');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':oid'=>$oid
        ));

        return $answer;
    }
    
    public static function updateCustomerByParam($pole, $val, $cid){

        $db = Db::getConection();

        $res = $db->prepare('UPDATE `oldi_customer` SET `' . $pole . '`=:val WHERE `id`=:id');
        $answer = $res->execute(array(
            ':val'=>$val,
            ':id'=>$cid
        ));

        return $answer;
    }
    
    public static function getPlansByPeriod($begin,$end){

        $db = Db::getConection();

        $orderList = array();
        //              SELECT `contract`,`oid`,`plan`,`tech_end`,`upak_end`,`otgruz_end`


        $res = $db->prepare('SELECT * FROM `oldi_orders`, `oldi_stan` WHERE `oldi_stan`.`oid` = `oldi_orders`.`id` AND `plan` BETWEEN ? AND ?');
        $res->execute(array($begin,$end));
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
              SELECT `contract` AS `con`,`id` AS `oid`,`plan`,`tip`,`mkv` AS `mater`
			  FROM `oldi_orders`
			  WHERE `plan` >= CURDATE()
			  ");
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        $today = strtotime('today');
        while ($row = $res->fetch()){
            $date = strtotime($row['plan']);
            $daysdiff = ($date - $today)/60/60/24;
            $orderList[$daysdiff][] = $row;
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
SELECT CONCAT('.$str.') AS `stan`
FROM `oldi_stan`
WHERE `oid` = :val
';
        $res = $db->prepare($strprep);
        $res->execute(array(':val'=>$oid));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
//return $strprep;
    }
    
    public static function getStanByOid($id){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `oldi_stan` WHERE `oid` = ?');
        $res->execute(array($id));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();

    }

    public static function add($contract, $tip, $dcon, $mkv, $sum, $predopl, $bezn, $color, $radius, $pokr, $dopef, $fotopec, $term, $dil, $note,$gmid){

        $db = Db::getConection();

        //Именованные метки
        $stmt = $db->prepare("INSERT INTO oldi_orders (contract,gmid,contract_date,mkv,tip,color,pokr,dop_ef,term,sum,prepayment,beznal,date,plan,radius,fotopec,idcustomer,note)
VALUES (:contract,:gmid,:contract_date,:mkv,:tip,:color,:pokr,:dop_ef,:term,:sum,:prepayment,:beznal, CURRENT_DATE,:plan,:radius,:fotopec,:dil,:note)");
        $res1 = $stmt -> execute(array(
            'contract'=>$contract,
            'gmid'=>$gmid,
            'contract_date'=> Datas::dateToDb($dcon),
            'mkv'=>$mkv,
            'tip'=>$tip,
            'color'=>$color,
            'pokr'=>$pokr,
            'dop_ef'=>$dopef,
            'term'=> $term,
            'sum'=>$sum,
            'prepayment'=>$predopl,
            'beznal'=>$bezn,
            'plan'=>$term,
            'radius'=>$radius,
            'fotopec'=>$fotopec,
            'dil'=>$dil,
            'note'=>$note
        ));

        $oid = $db->lastInsertId ();

        $stmt2 = $db -> prepare("INSERT INTO oldi_stan (oid) VALUES (:oid) ");
        $res2 = $stmt2 -> execute(array(':oid' => $oid));

        $res = $res1 && $res2;
        if($res) return $oid;
        else return false;
        
    }
    
    public static function delOrderById($id){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `oldi_orders` WHERE `id` = ?');
        $answ = $res->execute(array($id));

        return $answ;

    }

    public static function addCustomer($name, $phone){

        $db = Db::getConection();

        $res = $db->prepare("INSERT INTO oldi_customer (name, diller, phone) VALUES (:name, '0', :phone)");
        $res->execute(array(
            ':name'=>$name,
            ':phone'=>$phone
        ));
        $custid = $db->lastInsertId ();

        return $custid;

    }
}