<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.12.2015
 * Time: 17:10
 */

class Controller_collector {

    function actionIndex(){//сюда должен присылать главный контроллер только сборщиков

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

        $user = $_COOKIE['uid'];

        if($ri!=17){
            header('Location: /'.SITE_DIR.'/schedule');
        }

        //выбрать заказы незакрытые
        $order_current = OrderStan::getOrdersByPole('sborka_end','0');
        $order_plan = array();
        foreach($order_current as $key=>$order){
            $sb_date = strtotime($order['sborka_date']);
            $info = Order::getOrderById($key);
            if ($info['collector']!=$user){//отбираем только этого сборщика
                unset ($order_current[$key]);
            }else{
                $order_current[$key] = array_merge($order_current[$key],$info);
                if($sb_date>strtotime('today')){
                    //заказы в планах с завтрашнего дня
                    $order_plan[$key] = $order_current[$key];
                    unset ($order_current[$key]);
                }
            }
        }

        //заказы закрытые за последние 30 дней
        $order_end = OrderStan::getSobr('2',$user);

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