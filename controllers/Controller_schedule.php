<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 10.12.2015
 * Time: 15:56
 */

class Controller_schedule {

    public $order;
    public $claim;
    public $list_claim;

    public function formMass($idList){
        $todW = date('W', strtotime('today'));
        $claimList = array();
        $orderList = array();
        foreach ($idList as $order){
            //номер текущей недели

            $nweek = date('W', strtotime($order['plan']))-$todW;
            $dweek = date('w', strtotime($order['plan']));

            $orderOne = Order::getOrderById($order['oid']);
            if(isset($orderOne['contract'])){
                if(Datas::isRekl($orderOne['contract'])){
                    if($order['otgruz_end'] == 2 || $orderOne['sum'] >= 1000){
                        $claimList[$nweek.'-'.$dweek][$order['oid']] = $orderOne;
                        $claimList[$nweek.'-'.$dweek][$order['oid']]['plan'] = $order['plan'];
                        $claimList[$nweek.'-'.$dweek][$order['oid']]['tech_end'] = $order['tech_end'];
                        $claimList[$nweek.'-'.$dweek][$order['oid']]['upak_end'] = $order['upak_end'];
                        $claimList[$nweek.'-'.$dweek][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                    }
                }else{
                    $orderList[$nweek.'-'.$dweek][$order['oid']] = $orderOne;
                    $orderList[$nweek.'-'.$dweek][$order['oid']]['plan'] = $order['plan'];
                    $orderList[$nweek.'-'.$dweek][$order['oid']]['tech_end'] = $order['tech_end'];
                    $orderList[$nweek.'-'.$dweek][$order['oid']]['upak_end'] = $order['upak_end'];
                    $orderList[$nweek.'-'.$dweek][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                }
            }
        }
        $this->order = $orderList;
        $this->claim = $claimList;
    }

    function actionOrders(){

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

        //количество недель для отображения
        $nW = 6;
        $today = strtotime('today');

        $first =  date('Y-m-d', strtotime('last sunday + 24 hours -1 week'));
        $last =  date('Y-m-d', strtotime('last sunday + 24 hours +'.$nW.' week'));
        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $this->formMass($idList);

        $orderList = $this->order;

        $page = SITE_PATH.'views/schedule.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionClaim(){

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

        //количество недель для отображения
        $nW = 6;
        $today = strtotime('today');

        $first =  date('Y-m-d', strtotime('last sunday + 24 hours -1 week'));
        $last =  date('Y-m-d', strtotime('last sunday + 24 hours +'.$nW.' week'));
        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $this->formMass($idList);

        $orderList = $this->claim;

        $page = SITE_PATH.'views/schedule.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionChangeSum(){
        $oid = $_POST['oid'];
        $sum = $_POST['sum'];

        Order::updateOrdersByParam('sum',$sum,$oid);

        return true;
    }
}