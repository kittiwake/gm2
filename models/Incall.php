<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 29.03.2018
 * Time: 13:54
 */

class Incall {
    public static function add($event, $date, $pbxid, $uphone, $fabnum, $internal, $duration=0, $disposition='', $status_code=0, $is_recorded=0, $call_id_with_rec=''){
        $db = Db::getConection();

        $stmt = $db->prepare("
INSERT INTO incall
VALUES ('', :event, :date, :pbxid, :uphone, :fabnum, :internal, :duration, :disposition, :status_code, :is_recorded, :call_id_with_rec)
");

        $stmt -> execute(array(
            'event'=>$event,
            'date'=>$date,
            'pbxid'=>$pbxid,
            'uphone'=>$uphone,
            'fabnum'=>$fabnum,
            'internal'=>$internal,
            'duration'=>$duration,
            'disposition'=>$disposition,
            'status_code'=>$status_code,
            'is_recorded'=>$is_recorded,
            'call_id_with_rec'=>$call_id_with_rec
        ));

        $oid = $db->lastInsertId ();

        return $oid;
    }

//    public static function getNewCall($internal){
//        $db = Db::getConection();
//
//        $res = $db->prepare("
//SELECT * FROM `incall`
//WHERE `event`='NOTIFY_INTERNAL'
//AND `call_start` > (now()-INTERVAL 2 SECOND)
//AND `internal` = :internal
//");
//        $res->execute(array(
//            ':internal'=>$internal
//        ));
//        return $res->fetch();
//    }

    public static function getLastNotify($callerid){
        $db = Db::getConection();

        $call = null;

        $res = $db->prepare("
SELECT * FROM `incall`
WHERE `caller_id` = :callid
");
        $res->execute(array(
            ':callid'=>$callerid
        ));
        while ($row = $res->fetch()){
            $call = $row;
        }

        return $call;
    }


} 