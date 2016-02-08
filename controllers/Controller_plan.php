<?php

class Controller_plan {

    function actionTech(){
        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

        //получить список технологов
        $userList6 = User_post::getUsersByPost(6);
        $userList7 = User_post::getUsersByPost(7);
        $userList=$userList6+$userList7;
        $techList = array();
        foreach ($userList as $techid){
            $datatech = Users::getUserById($techid['uid']);
            if($datatech['validation'] == 1){
                $techList[] = array('uid' => $datatech['id'], 'name' => Datas::nameAbr($datatech['name']));
            }
        }
 //        var_dump($techList);die;
        $no_reckoning = array();
        $orderList = Order::getOrdersNoReckoning();
        foreach($orderList as $order){
            $techdate = strtotime($order['tech_date']);
            if($techdate<strtotime('today')){
                $order['tech_date'] = date('Y-m-d',strtotime('yesterday'));
            }
            $no_reckoning[$order['technologist'].'-'.$order['tech_date']][$order['oid']] = $order['contract'];
        }

//var_dump($no_reckoning); die;
        $no_appoint = Order::getOrdersNoaAppointTech();

        //список дизайнеров
        $userList5 = User_post::getUsersByPost(5);
        $disList = array();
        foreach($userList5 as $disid){
            $datadis = Users::getUserById($disid['uid']);
            $disList[$datadis['id']] = Datas::nameAbr($datadis['name']);
        }
//var_dump($disList);die;

        $page = SITE_PATH.'views/plantech.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionChangeTech(){
        $oid = $_POST['oid'];
        $data = explode('-', $_POST['table']);
        $tech = $data[0];
        $datedb = $data[1].'-'.$data[2].'-'.$data[3];

        //technologist tech_date
        Order::updateOrdersByParam('technologist',$tech,$oid);
        OrderStan::updateStanByParam('tech_date',$datedb,$oid);

        return true;
    }
} 