<?php

class Controller_plan {

    public $shablon = array(
        array(
            0=>'пила',
            1=>'чпу',
            3=>'кромка',
            4=>'присадка',
            2=>'гнутье',
            11=>'фасады',
            12=>'упаковка'
        ),
        array(
            6=>'пвх',
            5=>'эмаль',
            7=>'фотопечать',
            8=>'пескоструй',
            9=>'витраж',
            10=>'оракал',
        ));
    public $arr_stan_date = array('raspil_date', 'cpu_date', 'gnutje_date', 'kromka_date', 'pris_date', 'emal_date', 'pvh_date', 'photo_date', 'pesok_date', 'vitrag_date', 'oracal_date', 'fas_date', 'upak_date');
    public $arr_stan = array('raspil', 'cpu', 'gnutje', 'kromka', 'pris_end', 'emal', 'pvh', 'photo', 'pesok', 'vitrag', 'oracal', 'fas', 'upak_end');

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

    function actionCeh($date=null){
        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }elseif($ri!=3 && $ri!=1){
            header('Location: /'.SITE_DIR.'/schedule/orders');
        }
        if($date==null) $date = strtotime('today');
        $userdate = date('d.m.Y', $date);

        $today = strtotime('today');
        $orders = Order::getOrdersFromToday();//готовый массив [дата][0]=>{[oid]=>oid, [con]=>контракт}
        $stan_gotov = array();
        foreach($orders as $list){
            foreach($list as $order){
                $stan_gotov[$order['oid']] = OrderStan::getStanString($order['oid']);
            }
        }

        $graf = array();
        $graf_y = array();
        $arr_stan_date = $this->arr_stan_date;
        $arr_stan = $this->arr_stan;
        foreach($arr_stan_date as $stan_date){
            $graf[$stan_date]=array();
            $graf_y[$stan_date]=array();
        }
            $shablon = $this->shablon;
        foreach($arr_stan_date as $key=>$stan){
            $orders_gr = OrderStan::getOrdersByPole($stan, date('Y-m-d', $date));
            $orders_yesterday = OrderStan::getNeVipoln($stan,$arr_stan[$key]);
            foreach($orders_gr as $oid=>$arr){
                $aboutord = Order::getOrderById($oid);
                if(!empty($aboutord)){
                    $graf[$stan][$oid] = $arr + $aboutord;
                }
            }
            if(!$orders_gr){
                $graf[$stan] = array();
            }
            foreach($orders_yesterday as $oid=>$arr){
                $aboutord = Order::getOrderById($oid);
                if(!empty($aboutord)){
                    $graf_y[$stan][$oid] = $arr + $aboutord;
                }
            }
            if(!$orders_yesterday){
                $graf_y[$stan] = array();
            }
        }
        $page = SITE_PATH.'views/planceh.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionChangeDateStan(){
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $poledb = $this->arr_stan_date[$pole];
        $date = $_POST['date'];
        $datedb = preg_replace('/(\d{1,2})\.(\d{1,2})\.(\d{4})/','\3-\2-\1',$date);

        $resget = OrderStan::getOrdersByPole('oid', $oid);
        if($resget[$oid][$poledb] == '0000-00-00'){
            $res = OrderStan::updateStanByParam($poledb,$datedb,$oid);
        }else{
            $res = $resget[$oid][$poledb];
        }
        echo $res;

        return true;
    }

}