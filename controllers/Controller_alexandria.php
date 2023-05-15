<?php

class Controller_alexandria {

    function actionSchedule(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,3,4,16);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $nW = 6;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600;
        $end = $begin+(2+$nW)*7*24*3600;

        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);

        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $todW = date('W', strtotime('today'));

        foreach ($idList as $order){
            $key = strtotime($order['plan']);
            $nweek = date('W', strtotime($order['plan']))-$todW;
            $dweek = date('w', strtotime($order['plan']));
            if($order['photo']!=1 || $order['pesok']!=1 || $order['oracal']!=1 || $order['vitrag']!=1){
                $orderOne = Order::getOrderById($order['oid']);
                if(isset($orderOne['contract'])) {
                        $orderList[$key][$order['oid']] = $orderOne;
                        $orderList[$key][$order['oid']]['plan'] = $order['plan'];
                        $orderList[$key][$order['oid']]['tech_end'] = $order['tech_end'];
                        $orderList[$key][$order['oid']]['upak_end'] = $order['upak_end'];
                        $orderList[$key][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                        $orderList[$key][$order['oid']]['photo'] = $order['photo'];
                        $orderList[$key][$order['oid']]['pesok'] = $order['pesok'];
                        $orderList[$key][$order['oid']]['oracal'] = $order['oracal'];
                        $orderList[$key][$order['oid']]['vitrag'] = $order['vitrag'];
                        $delivList[$order['oid']] = Material::getOrderMaterial($order['oid']);

                }
            }

        }
        //заливка фона завершен/незавершен
        $bcgcolor = array('#CCFFFF','','#33bb00');


        $page = SITE_PATH.'views/alexschedule.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

} 