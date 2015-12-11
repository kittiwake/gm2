<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 10.12.2015
 * Time: 15:56
 */

class Controller_schedule {

    function actionIndex(){

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];

        //количество недель для отображения
        $nW = 6;

        //номер текущей недели
        $todW = date('W', strtotime('today'));
        $today = strtotime('today');

        $first =  date('Y-m-d', strtotime('last Monday -1 week'));
        $last =  date('Y-m-d', strtotime('last Monday +'.$nW.' week'));

        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $orderList = array();

        //ищем заказы по id //фильтруем и раскидываем по массиву $order[w][d]
        $i = 0;
        foreach ($idList as $order){
            $nweek = date('W', strtotime($order['plan']))-$todW;
            $dweek = date('w', strtotime($order['plan']));

            $orderList[$nweek.'-'.$dweek][$order['oid']] = Order::getOrderById($order['oid']);
            if(isset($orderList[$nweek.'-'.$dweek][$order['oid']]['contract'])){
                $orderList[$nweek.'-'.$dweek][$order['oid']]['plan'] = $order['plan'];
                $orderList[$nweek.'-'.$dweek][$order['oid']]['tech_end'] = $order['tech_end'];
                $orderList[$nweek.'-'.$dweek][$order['oid']]['upak_end'] = $order['upak_end'];
                $orderList[$nweek.'-'.$dweek][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
            }else{
                unset($orderList[$nweek.'-'.$dweek][$order['oid']]);
            }
            $i++;
        }

        $page = SITE_PATH.'views/schedule.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
}