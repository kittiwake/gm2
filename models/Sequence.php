<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 26.02.2018
 * Time: 17:44
 */
//*этот класс должен заменить класс progression*//

class Sequence {

    public static function setSequence($oid,$pole,$value,$gmol){
//$pole - строковая переменная
        $db = Db::getConection();
        $res = $db->prepare("
SELECT * FROM `sequence` WHERE `oid`=:oid AND `pole`=:pole and `gm_ol`=:gmol
");
        $res->execute(array(
            'oid'=>$oid,
            'pole' => $pole,
            'gmol' => $gmol
        ));
        if($res->fetch()==null){
            $stmt = $db->prepare("INSERT INTO `sequence` (`oid`, `pole`,`sequence`,`gm_ol`) VALUES (:id, :pole, :val,  :gmol)");
        }else{
            $stmt = $db->prepare('UPDATE `sequence` SET `sequence`=:val WHERE `oid`=:id AND `pole`=:pole AND `gm_ol`=:gmol' );
        }

        $res = $stmt -> execute(array(
            'id' => $oid,
            'pole' => $pole,
            'val' => $value,
            'gmol' => $gmol
        ));
    }

    public static function getProgressionsByOid($oid){
        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `sequence` WHERE `oid` = ?');
        $res->execute(array($oid));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getSequenceForDate($pole,$pole_date,$date){
        $db = Db::getConection();

        $sql = "SELECT orders.id, orders.contract, order_stan.".$pole.", order_stan.".$pole_date.",
            (SELECT sequence.sequence FROM sequence WHERE sequence.oid = orders.id AND sequence.pole='".$pole."' AND `gm_ol`='g') AS `sequence`,
            (SELECT bossnotes.noteboss FROM bossnotes WHERE bossnotes.oid = orders.id AND bossnotes.pole='mater') AS `mater`
            FROM `orders`,`order_stan`
            WHERE order_stan.oid=orders.id
            AND order_stan.otgruz_end = 0
            AND order_stan.".$pole_date."=?
            order by `sequence`";


        $res = $db->prepare($sql);
        $res->execute(array($date));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getPartSequenceForDate($pole,$pole_date,$date){
        $db = Db::getConection();

        //SELECT orders.id, orders.contract, order_stan.".$pole.", order_stan.".$pole_date.",
        //(SELECT sequence.sequence FROM sequence WHERE sequence.oid = orders.id AND sequence.pole='".$pole."') AS `sequence`,
        //(SELECT bossnotes.noteboss FROM bossnotes WHERE bossnotes.oid = orders.id AND bossnotes.pole='mater') AS `mater`

        $sql = "SELECT `order_part`.`oid`, `order_part`.`id` as partid, orders.contract, order_part.suf, order_part.".$pole.", order_part.".$pole_date.", `sequence`.`sequence`, order_part.note,
FROM `order_part` 
left join `orders` on `orders`.`id` = `order_part`.`oid`
left join `sequence` on `sequence`.`partid` = `order_part`.`id`
            WHERE order_part.".$pole_date."=?
            and `order_part`.".$pole_date." IS NOT NULL 
            order by `sequence`";


        $res = $db->prepare($sql);
        $res->execute(array($date));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getPartSequenceTillToday($pole,$pole_date){
        $db = Db::getConection();

        $sql = "SELECT * 
FROM `order_part` 
left join `orders` on `orders`.`id` = `order_part`.`oid`
left join `sequence` on `sequence`.`partid` = `order_part`.`id`
            WHERE (order_part.".$pole." = 0
            AND `order_part`.".$pole_date."<CURRENT_DATE
            and `order_part`.".$pole_date." IS NOT NULL )
            OR order_part.".$pole_date."=CURRENT_DATE
            order by `sequence`";


        $res = $db->prepare($sql);
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getSequenceTillToday($pole,$pole_date){
        $db = Db::getConection();

        $sql = "SELECT orders.id, orders.contract, order_stan.".$pole.", order_stan.".$pole_date.",
            (SELECT sequence.sequence FROM sequence WHERE sequence.oid = orders.id AND sequence.pole='".$pole."' AND `gm_ol`='g') AS `sequence`,
            (SELECT bossnotes.noteboss FROM bossnotes WHERE bossnotes.oid = orders.id AND bossnotes.pole='mater') AS `mater`
            FROM `orders`,`order_stan`
            WHERE order_stan.oid=orders.id
            AND ((order_stan.".$pole." = 0
            AND order_stan.".$pole_date."<CURRENT_DATE)
            OR order_stan.".$pole_date."=CURRENT_DATE)
            AND order_stan.".$pole_date."!='0000-00-00'
            order by `sequence`";


        $res = $db->prepare($sql);
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getOldiSequenceTillToday($pole,$pole_date){
        $db = Db::getConection();

        $sql = "SELECT oldi_orders.id, oldi_orders.contract, oldi_stan.".$pole.", oldi_stan.".$pole_date.",
            (SELECT sequence.sequence FROM sequence WHERE sequence.oid = oldi_orders.id AND sequence.pole='".$pole."' AND `gm_ol`='o') AS `sequence`,
            oldi_orders.mkv AS `mater`,
            oldi_orders.tip
            FROM `oldi_orders`,`oldi_stan`
            WHERE oldi_stan.oid=oldi_orders.id
            AND ((oldi_stan.".$pole." = 0
            AND oldi_stan.".$pole_date."<CURRENT_DATE)
            OR oldi_stan.".$pole_date."=CURRENT_DATE)
            order by `sequence`";


        $res = $db->prepare($sql);
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }

    public static function getOldiSequenceForDate($pole,$pole_date,$date){
        $db = Db::getConection();

        $sql = "SELECT oldi_orders.id, oldi_orders.contract, oldi_stan.".$pole.", oldi_stan.".$pole_date.",
            (SELECT sequence.sequence FROM sequence WHERE sequence.oid = oldi_orders.id AND sequence.pole='".$pole."' AND `gm_ol`='o') AS `sequence`,
            oldi_orders.mkv AS `mater`,
            oldi_orders.tip
            FROM `oldi_orders`,`oldi_stan`
            WHERE oldi_stan.oid=oldi_orders.id
            AND oldi_stan.otgruz = 0
            AND oldi_stan.".$pole_date."=?
            order by `sequence`";


        $res = $db->prepare($sql);
        $res->execute(array($date));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $orderList = array();
        while ($row = $res->fetch()){
            $orderList[] = $row;
        }
        return $orderList;
    }


} 