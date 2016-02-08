<?php

class Controller_technologist {

    function actionSchedule(){
        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }
        $user = $_COOKIE['uid'];

        if($ri!=6 && $ri!=7 && $ri!=1){
            header('Location: /'.SITE_DIR.'/schedule');
        }

        //выбрать заказы несчитанные
        $order_current = OrderStan::getOrdersByPole('tech_end','0');
        foreach($order_current as $key=>$order){
            $tech_date = strtotime($order['tech_date']);
            $info = Order::getOrderById($key);
            if ($info['technologist']!=$user){//отбираем только этого технолога
                unset ($order_current[$key]);
            }else{
                $order_current[$key] = array_merge($order_current[$key],$info);
            }
        }

        $begindate = date('Y-m-d', strtotime('first day of'));
        $enddate = date('Y-m-d', strtotime('today'));
        //заказы закрытые за последние 30 дней
        $order_end = OrderStan::getTechEnd($user,$begindate,$enddate);
var_dump($order_end); die;
        $page = SITE_PATH.'views/collector.php';
        include (SITE_PATH.'views/layout.php');


        return true;
    }
} 