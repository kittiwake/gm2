<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.12.2015
 * Time: 17:10
 */

class Controller_collector {

    function actionIndex(){//сюда должен присылать главный контроллер только сборщиков

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $user = $_SESSION['uid'];
//        $user = 87;
        $allowed = array(1,17);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $datadis = Users::getUserById($disid['uid']);
        if($datadis['validation'] == 1){
            $disList[] = array('uid' => $datadis['id'], 'name' => Datas::nameAbr($datadis['name']));
        }


//        if($ri!=17){
//            header('Location: /schedule');
//        }

        //выбрать заказы сборщика
//        SELECT `mounting`.`oid` , `sborka_end` , `sborka_end_date` , `uid` , `m_date`
//FROM `mounting` , `order_stan`
//WHERE `uid` =87
//        AND `mounting`.`oid` = `order_stan`.`oid`
        $mountList = Mounting::getMountingsByUid($user);
        $mount_plan = array();
        $mount_curr = array();
        $mount_end = array();
        foreach($mountList as $mount){
            $sbend = strtotime($mount['sborka_end_date']);
            $repbegin = strtotime('today - 30 days');//30 дней для отчета

            $dis = Users::getUserById($mount['designer']);
            $tech = Users::getUserById($mount['technologist']);

            $notes = Notes::getNotesByOid($mount['oid']);
            $m_notes = '';
            foreach($notes as $note){
                if($note['use'] == 'mounting'){
                    $date_html = date('d.m', strtotime($note['date']));
                    $m_notes .= '<br><b>'.$date_html.'</b> '.$note['note'];
                }
            }
            $mount['notes'] = $m_notes;
            $mount['designer'] = Datas::nameAbr($dis['name']);
            $mount['technologist'] = Datas::nameAbr($tech['name']);

            if($mount['sborka_end'] == 0){
                if(strtotime($mount['m_date'])>strtotime('today')){
                    $mount_plan[] = $mount;
                }else{
                    $mount_curr[] = $mount;
                }
            }elseif($sbend > $repbegin){
                $mount_end[] = $mount;
            }
        }
//        var_dump($mount_plan); die;
        //выбрать заказы незакрытые
//        $order_current = OrderStan::getOrdersByPole('sborka_end','0');
//        $order_plan = array();
//        foreach($order_current as $key=>$order){
//            $sb_date = strtotime($order['sborka_date']);
//            $info = Order::getOrderById($key);
//            if ($info['collector']!=$user){//отбираем только этого сборщика
//                unset ($order_current[$key]);
//            }else{
//                $order_current[$key] = array_merge($order_current[$key],$info);
//                if($sb_date>strtotime('today')){
//                    //заказы в планах с завтрашнего дня
//                    $order_plan[$key] = $order_current[$key];
//                    unset ($order_current[$key]);
//                }
//            }
//        }

        //заказы закрытые за последние 30 дней
//        $order_end = OrderStan::getSobr('2',$user);

        $page = SITE_PATH.'views/collector.php';
        include (SITE_PATH.'views/layout.php');


return true;
    }

    function actionClose($oid){
        $today = date('Y-m-d', strtotime('today'));
        //получить данные о рекламациях
        $con = Order::getOrderById($oid);
        $noer = 1;
        if(!Datas::isRekl($con['contract'])){
            $allrekl = Order::getOrdersLikeParam('contract',$con['contract']);
            foreach($allrekl as $order){
                $rekl = Datas::isRekl($order['contract']);
                $stan = OrderStan::getOrdersByPole('oid',$order['id']);
                if($stan[$order['id']]['sborka_end']==0&&$rekl==1){
                    $noer = 0;
                }
            }
        }

        if($noer == 1){
            $res1 = OrderStan::updateStanByParam('sborka_end_date', $today,$oid);
            $res2 = OrderStan::updateStanByParam('sborka_end','2',$oid);
            echo $res1&&$res2;
 //           echo $noer;
        }else{
            echo $noer;
        }

        return true;
    }

}