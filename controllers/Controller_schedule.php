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

//    public function formMass($idList){
//        $todW = date('W', strtotime('today'));
//        $claimList = array();
//        $orderList = array();
//        foreach ($idList as $order){
//            //номер текущей недели
//
//            $nweek = date('W', strtotime($order['plan']))-$todW;
//            $dweek = date('w', strtotime($order['plan']));
//
//            $orderOne = Order::getOrderById($order['oid']);
//            if(isset($orderOne['contract'])){
//                if(Datas::isRekl($orderOne['contract'])){
////                    if($order['otgruz_end'] == 2 || $orderOne['sum'] >= 1000){
//                        $claimList[$nweek.'-'.$dweek][$order['oid']] = $orderOne;
//                        $claimList[$nweek.'-'.$dweek][$order['oid']]['plan'] = $order['plan'];
//                        $claimList[$nweek.'-'.$dweek][$order['oid']]['tech_end'] = $order['tech_end'];
//                        $claimList[$nweek.'-'.$dweek][$order['oid']]['upak_end'] = $order['upak_end'];
//                        $claimList[$nweek.'-'.$dweek][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
////                    }
//                }else{
//                    $orderList[$nweek.'-'.$dweek][$order['oid']] = $orderOne;
//                    $orderList[$nweek.'-'.$dweek][$order['oid']]['plan'] = $order['plan'];
//                    $orderList[$nweek.'-'.$dweek][$order['oid']]['tech_end'] = $order['tech_end'];
//                    $orderList[$nweek.'-'.$dweek][$order['oid']]['upak_end'] = $order['upak_end'];
//                    $orderList[$nweek.'-'.$dweek][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
//                }
//            }
//        }
//        $this->order = $orderList;
//        $this->claim = $claimList;
//    }

    public function formMass($idList, $pole='plan'){
        $todW = date('W', strtotime('today'));
        $claimList = array();
        $orderList = array();
        foreach ($idList as $order){
            //номер текущей недели

            $orderOne = Order::getOrderById($order['oid']);
            if(isset($orderOne['contract'])){
                $key = strtotime($order[$pole]);
                if(Datas::isRekl($orderOne['contract'])){
//                    if($order['otgruz_end'] == 2 || $orderOne['sum'] >= 1000){
                        $claimList[$key][$order['oid']] = $orderOne;
                        $claimList[$key][$order['oid']]['plan'] = $order[$pole];
                        $claimList[$key][$order['oid']]['pre_plan'] = $order['plan'];
                        $claimList[$key][$order['oid']]['tech_end'] = $order['tech_end'];
                        $claimList[$key][$order['oid']]['upak_end'] = $order['upak_end'];
                        $claimList[$key][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
//                    }
                }else{
                    if($orderOne['archive']==0){
                        $orderList[$key][$order['oid']] = $orderOne;
                        $orderList[$key][$order['oid']]['plan'] = $order[$pole];
                        $orderList[$key][$order['oid']]['pre_plan'] = $order['plan'];
                        $orderList[$key][$order['oid']]['tech_end'] = $order['tech_end'];
                        $orderList[$key][$order['oid']]['upak_end'] = $order['upak_end'];
                        $orderList[$key][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                        if($pole=='pre_plan'){
                            $g = Bossnotes::getNote($order['oid'],'mater');
                            $orderList[$key][$order['oid']]['bossnote'] = empty($g)?'':$g['noteboss'];
                        }
                    }
                }
            }
        }
        $this->order = $orderList;
        $this->claim = $claimList;
        return $pole;
    }

    function actionPre(){

        $sess = $_SESSION;
        $ri = $sess['ri'];
        
        $allow = Allowed::getAllowed('schedule','Pre');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $log = $sess['login'];
        //количество недель для отображения
        $nW = 10;
        //количество прошедших недель
        $Wbefore = 1;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600*$Wbefore;
        $end = $begin+(2+$nW)*7*24*3600;

        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);
        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
//        var_dump(date('d-m-Y',$begin));
//        var_dump(date('d-m-Y',$end));
//        var_dump($idList);die;
        $this->formMass($idList, 'pre_plan');
//var_dump($pole);die;
        $orderList = $this->order;
        // debug($orderList);die;
        $style = '
        <style type="text/css">
        .column{
            display: inline-block;
            width: 45%;
            vertical-align: top;
            border-left: solid 2px bisque;
            border-right: solid 2px bisque;
        }
        .metka{
            clip-path: polygon(100% 0, 100% 100%, 0 100%, 0 15px, 15px 0);
        }
</style>
';
        $page = SITE_PATH.'views/preschedule.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionOrders(){

        $sess = $_SESSION;
        $ri = $sess['ri'];
        $allow = Allowed::getAllowed('schedule','Orders');
        $allowed = explode(",", $allow);
// debug ($arr); die;

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $log = $sess['login'];
        //количество недель для отображения
        $nW = 10;
        //количество прошедших недель
        $Wbefore = 4;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600*$Wbefore;
        $end = $begin+(2+$nW)*7*24*3600;

        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);
        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
//        var_dump(date('d-m-Y',$begin));
//        var_dump(date('d-m-Y',$end));
//        var_dump($idList);die;
        $this->formMass($idList);
//        var_dump($pole);die;

        $orderList = $this->order;
//        var_dump($orderList);die;

        $url = '/order/index/';

        if(in_array($ri,array(0,6,12,20))){
            $page = SITE_PATH.'views/schedulesimpl.php';
        }else{
            $page = SITE_PATH.'views/schedule.php';
        }
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionClaim(){

        $sess = $_SESSION;
        $ri = $sess['ri'];
        $log = $sess['login'];
        $allow = Allowed::getAllowed('schedule','Claim');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        //количество недель для отображения
        $nW = 10;
        $Wbefore = 4;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600*$Wbefore;
        $end = $begin+(2+$nW)*7*24*3600;

        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);
        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $this->formMass($idList);

        $orderList = $this->claim;

        $url = '/order/index/';

        if(in_array($ri,array(0,6,12,20))){
            $page = SITE_PATH.'views/schedulesimpl.php';
        }else{
            $page = SITE_PATH.'views/schedule.php';
        }
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    
    function actionArchive(){
        $sess = $_SESSION;
        $ri = $sess['ri'];
        $log = $sess['login'];
        $allow = Allowed::getAllowed('schedule','Archive');
        $allowed = explode(",", $allow);

        // $allowed = array(1,3,4);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        //список дизайнеров и технологов
        $dis = Users::getUserByPost(5);
        $tech = Users::getUserByPost(6);
        $disList = array();
        $techList = array();
//список дизайнеров
        foreach ($dis as $uid){
            $abr = Datas::nameAbr($uid['name']);
//                $abr = Datas::nameAbr($datasb['name']);
                $disList[$uid['id']] = $abr;
        }
        asort($disList);
        
//список технологов
        foreach ($tech as $uid){
            $abr = Datas::nameAbr($uid['name']);
//                $abr = Datas::nameAbr($datasb['name']);
                $techList[$uid['id']] = $abr;
        }
        asort($techList);
        
        
        // debug ($techList);
        $orders = Order::getOrdersByParam('archive', 1);
       // debug ($orders);
        
        $page = SITE_PATH.'views/archive.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionChangeSum(){
        $oid = $_POST['oid'];
        $sum = $_POST['sum'];

        Order::updateOrdersByParam('sum',$sum,$oid);

        return true;
    }

    function actionMdf(){
        $sess = $_SESSION;
        $ri = $sess['ri'];
        $log = $sess['login'];
        $allow = Allowed::getAllowed('schedule','Mdf');
        $allowed = explode(",", $allow);

        // $allowed = array(1,2,20,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        //количество недель для отображения
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
            if($order['emal']!=1 || $order['pvh']!=1 ){
                $orderOne = Order::getOrderById($order['oid']);
                if(isset($orderOne['contract'])) {
                    $orderList[$key][$order['oid']] = $orderOne;
                    $orderList[$key][$order['oid']]['plan'] = $order['plan'];
                    $orderList[$key][$order['oid']]['tech_end'] = $order['tech_end'];
                    $orderList[$key][$order['oid']]['upak_end'] = $order['upak_end'];
                    $orderList[$key][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                    $orderList[$key][$order['oid']]['emal'] = $order['emal'];
                    $orderList[$key][$order['oid']]['pvh'] = $order['pvh'];
                }
            }

        }
        //заливка фона завершен/незавершен
        $bcgcolor = array('#CCFFFF','','#33bb00');

        $page = SITE_PATH.'views/oldi.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionChangePrePlan(){
        $oid = $_POST['oid'];
        $predate = Datas::dateToDb($_POST['preplan']);
        $res = OrderStan::updateStanByParam('pre_plan',$predate,$oid);
        if($res) echo strtotime($predate);
        else echo $res;
        return true;
    }

    function actionFixPlan(){
        $oid = $_POST['oid'];
        $res = OrderStan::updatePlanAsPreplan($oid);
        echo $res;
        return true;
    }
    
    function actionOldi($tip){ //$tip="pvh"||"emal"
        
        $sess = $_SESSION;
        $ri = $sess['ri'];
        $log = $sess['login'];
        $allow = Allowed::getAllowed('schedule','Oldi');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
        $log = $sess['login'];
        //количество недель для отображения
        $nW = 10;
        //количество прошедших недель
        $Wbefore = 4;
        if($ri == 44) $Wbefore = 0;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600*$Wbefore;
        $end = $begin+(2+$nW)*7*24*3600;

        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);
        //получить список id заказов в диапазоне дат
  //      $idList = OrderStan::getOrdersByPeriod($first, $last);
        $idList = Oldi::getOrdersByPeriod($first, $last, $tip);
        $orderList = array();
//        var_dump(date('d-m-Y',$begin));
//        var_dump(date('d-m-Y',$end));
//        debug($idList);die;
//        $this->formMass($idList);
//        var_dump($pole);die;
        foreach ($idList as $order){
            //номер текущей недели

//            $orderOne = Order::getOrderById($order['oid']);
                $key = strtotime($order['plan']);
                    $orderList[$key][$order['oid']] = $order;
                    $orderList[$key][$order['oid']]['technologist'] = 0;
                    $orderList[$key][$order['oid']]['rassr'] = 0;
                    $orderList[$key][$order['oid']]['tech_end'] = $order['v_ceh']==1?2:($order['v_ceh']==2?1:0);
                    $orderList[$key][$order['oid']]['upak_end'] = $order['upak']==1?2:($order['upak']==2?1:0);
                    $orderList[$key][$order['oid']]['otgruz_end'] = $order['otgruz']==1?2:($order['otgruz']==2?1:0);
                    $orderList[$key][$order['oid']]['attention'] = 0;
        }
 //       debug($orderList);die;
 
        $url = '/oldi/order/';
        $page = SITE_PATH.'views/schedule.php';
        if($ri == 44){
            $page = SITE_PATH.'views/schedulemal.php';
            $url = '/oldi/malar/';
        }
        include (SITE_PATH.'views/layout.php');

        return true;
        
    }
    
    
}