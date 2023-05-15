<?php

class Material {

    public static function getAllCategories($otd = 'm'){

        $db = Db::getConection();

        $catList = array();

        $res = $db->prepare("SELECT * FROM `categories_material` where `otdel`= :val");
        $res->execute(array(
            ':val' => $otd
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $catList[$row['id']] = $row['category'];
        }
        return $catList;
    }

    public static function addCategory($category){

        $db = Db::getConection();

        $res = $db->prepare('INSERT INTO `categories_material`(`category`) VALUES (:value)');
        $res->execute(array(
            ':value'=>$category
        ));

        return $db->lastInsertId();
    }
    public static function delCategoryById($catid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `categories_material` WHERE `id`=:val');
        $res->execute(array(
            ':val'=>$catid
        ));

        return $res;
    }
    public static function delOrderByOid($oid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `materials` WHERE `oid` = ?');
        $answ = $res->execute(array($oid));

        return $answ;
    }

    public static function getMaterialById($matid){

        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `materials` WHERE `id`=:dat');
        $res->execute(array(
            ':dat'=>$matid
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function getMaterialsByLogist($logid){

        $db = Db::getConection();
        $matList = array();
        $res = $db->prepare('SELECT * FROM `materials` WHERE `logist_id`=:dat');
        $res->execute(array(
            ':dat'=>$logid
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $matList[] = $row;
        }
        return $matList;
    }
    public static function delMaterialById($matid){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `materials` WHERE `id`=:val');
        $res->execute(array(
            ':val'=>$matid
        ));

        return $res;
    }
    public static function getMaterialsByOutlay($olid){

        $db = Db::getConection();
        $matList = array();
        $res = $db->prepare('SELECT 
        `id`, 
        (SELECT `orders`.`contract` FROM `orders` WHERE `materials`.`oid`=`orders`.`id`) as `contract`, 
        `designation`,
        `count`,
        `catid`,
        `prov_id`,
        `otdel`,
        `summ`,
        `outlay_id`
        FROM `materials` WHERE `outlay_id`=:dat');
        $res->execute(array(
            ':dat'=>$olid
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $matList[] = $row;
        }
        return $matList;
    }

    public static function getAllInfoDate($date){

        $db = Db::getConection();

        $matList = array();

        $res = $db->prepare("
SELECT
`materials`.`id`,
`materials`.`summ`,
`materials`.`plan_date`,
`materials`.`oid`,
`orders`.`contract`,
`materials`.`catid`,
`categories_material`.`category`,
`materials`.`prov_id`,
`providers`.`provider`,
`materials`.`logist_id`,
`logistic`.`date`,
`logistic`.`type`,
`logistic`.`note`,
`logistic`.`driver`
FROM `materials`
LEFT JOIN `categories_material`
ON `materials`.`catid`=`categories_material`.`id`
LEFT JOIN `providers`
ON `materials`.`prov_id`=`providers`.`id`
LEFT JOIN `logistic`
ON `materials`.`logist_id`=`logistic`.`id`
LEFT JOIN `orders`
ON `orders`.`id`=`materials`.`oid`
WHERE `logistic`.`date`=:dat
");
//        $res = $db->prepare("
//SELECT * FROM `materials`
//LEFT JOIN `categories_material`
//ON `materials`.`catid`=`categories_material`.`id`
//LEFT JOIN `logistic`
//ON `materials`.`logist_id`=`logistic`.`id`
//LEFT JOIN `orders`
//ON `orders`.`id`=`materials`.`oid`
//LEFT JOIN `providers`
//ON `materials`.`prov_id`=`providers`.`id`
//WHERE `plan_date` = :dat
//");
        $res->execute(array(
            ':dat'=>$date
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $matList[] = $row;
        }
        return $matList;
    }
    public static function getByDate($date){

        $db = Db::getConection();

        $matList = array();

        $res = $db->prepare('SELECT * FROM `materials` WHERE `plan_date`=:dat');
        $res->execute(array(
            ':dat'=>$date
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $matList[] = $row;
        }
        return $matList;
    }

    public static function getOrderMaterial($oid){

        $db = Db::getConection();

        $matList = array();

        $res = $db->prepare('SELECT * FROM `materials` WHERE `oid`=:oid');
        $res->execute(array(
            ':oid'=>$oid
        ));

        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $matList[] = $row;
        }
        return $matList;
    }
    public static function addOrderMaterial($oid, $catid, $mater,$otd='m'){

        $db = Db::getConection();

        $res = $db->prepare('
INSERT INTO `materials`(`oid`, `designation`, `catid`, `date`,`otdel`)
VALUES (:oid,:mat,:catid,CURRENT_DATE,:otd)'
        );
        $res->execute(array(
            ':oid'=>$oid,
            ':mat'=>$mater,
            ':catid'=>$catid,
            ':otd' => $otd
        ));

        return $db->lastInsertId();
    }

    public static function updateStatus($matid, $status){
        $db = Db::getConection();

        $res = $db->prepare('
UPDATE `materials`
SET `status`=:status
WHERE `id`=:mat
');
        $res->execute(array(
            ':status'=>$status,
            ':mat'=>$matid
        ));
        return $res;
    }
    public static function updateParametr($id,$pole,$val){
        $db = Db::getConection();

        $res = $db->prepare('
UPDATE `materials`
SET `'.$pole.'`=:val
WHERE `id`=:id
');
        return $res->execute(array(
            ':id'=>$id,
            ':val'=>$val
        ));
//        return $res;
    }

    public static function updateParamByLogist($lid,$pole,$val){
        $db = Db::getConection();

        $res = $db->prepare('
UPDATE `materials`
SET `'.$pole.'`=:val
WHERE `logist_id`=:id
');
        return $res->execute(array(
            ':id'=>$lid,
            ':val'=>$val
        ));
//        return $res;
    }

    public static function findProvider($name){
        $db = Db::getConection();

        $res = $db->prepare('SELECT * FROM `providers` WHERE `provider`=:val');
        $res->execute(array(
            ':val'=>$name
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }
    public static function addProvider($name){
        $db = Db::getConection();

        $res = $db->prepare('INSERT INTO `providers`(`provider`) VALUES (:value)');
        $res->execute(array(
            ':value'=>$name
        ));

        return $db->lastInsertId();
    }
    public static function addProvCateg($prid,$cid){
        $db = Db::getConection();

        $res = $db->prepare("INSERT INTO `mater-prov`(`mat_id`, `prov_id`) VALUES (:catid,:prid)");
        $res->execute(array(
            ':catid'=>$cid,
            ':prid'=>$prid
        ));

        return $db->lastInsertId();
    }
    public static function getProvCateg(){
        $db = Db::getConection();
        $list = array();
        $res = $db->prepare("SELECT
`mater-prov`.`id`,
`mat_id`,
`categories_material`.`category`,
`prov_id`,
`providers`.`provider`,
`providers`.`activity`
FROM `mater-prov`,`categories_material`,`providers`
WHERE `categories_material`.`id`=`mater-prov`.`mat_id`
AND `mater-prov`.`prov_id`=`providers`.`id`
");
        $res->execute();
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[$row['mat_id']][] = $row;
        }
        return $list;
    }
    
    public static function updateOutlayToMaterial($oid,$olid){
        $db = Db::getConection();

        $res = $db->prepare('
UPDATE `materials`
SET `outlay_id`=:olid
WHERE `oid`=:oid
AND `outlay_id` = 0
');
        return $res->execute(array(
            ':oid'=>$oid,
            ':olid'=>$olid
        ));
//        return $res;
    }

}