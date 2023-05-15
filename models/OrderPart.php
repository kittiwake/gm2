<?php
/**
 * Created by PhpStorm.
 * User: kitti
 * Date: 18.10.18
 * Time: 15:14
 */

class OrderPart
{
    public static function add($oid, $datas){

        $db = Db::getConection();
        $str = '';

        foreach ($datas as $data){
            if( $str != ''){
                $str .= ',';
            }
            $str .= "('" . $oid . "','" . $data->pre . "','" . $data->mater . "')";
        }
        $qwery = "INSERT INTO `order_part`(`oid`, `suf`, `note`) VALUES " . $str;


        $stmt = $db->prepare($qwery);

        $res = $stmt -> execute();

        return $res;
    }

    public static function getByOid($oid){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare("
              SELECT *
			  FROM `order_part`
			  WHERE `oid` = :oid
			  ");
        $res->execute(array(
            ':oid' => $oid,
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $res->fetch()){
            $list[] = $row;
        }

        return $list;
    }

    public static function getById($id){
        $db = Db::getConection();

        $list = array();

        $res = $db->prepare("
              SELECT *
			  FROM `order_part`
			  WHERE `id` = :id
			  ");
        $res->execute(array(
            ':id' => $id,
        ));
        $res->setFetchMode(PDO::FETCH_ASSOC);

        return $res->fetch();
    }

    public static function update($datas){
        $db = Db::getConection();
        $answ = true;
        foreach ($datas as $item){
            $res = $db->prepare("
UPDATE `order_part` SET `suf`=:pre,`note`=:mater WHERE `id`=:pid");
            $answ1 = $res->execute(array(
                ':pre' => $item->pre,
                ':mater' => $item->mater,
                ':pid' => $item->pid
            ));
            $answ = $answ && $answ1;
        }

        return $answ;
    }

    public static function updateParam($id, $pole, $val){
        $db = Db::getConection();
            $res = $db->prepare("
UPDATE `order_part` SET `" . $pole . "`=:pre WHERE `id`=:pid");
            $answ = $res->execute(array(
                ':pre' => $val,
                ':pid' => $id
            ));

        return $answ;
    }

    public static function deleteById($id){

        $db = Db::getConection();

        $res = $db->prepare('DELETE FROM `order_part` WHERE `id` = ?');
        $answ = $res->execute(array($id));

        return $answ;

    }

}