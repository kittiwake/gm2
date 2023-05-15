<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 24.08.2016
 * Time: 16:46
 */

class Controller_logistic {

    function actionIndex($date=null){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('logistic','Index');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        if(isset($_GET['date'])&&$_GET['date']!='') $date = $_GET['date'];
        $date = $date==null?strtotime('today'):$date;
        $dbdate = date('Y-m-d', $date);
        $ost_in = 0;

        //список поставщиков
        $providers = Providers::getAllProviders();
        // debug($providers);
//        addOut будем формировать автоматически из графика вывоза
        if(isset($_POST['addOut'])){
            if(!empty($_POST['point'])){
                $point = $_POST['point'];
                $address = $_POST['address'];
                $ostatok = $_POST['ostatok'];
                $note = $_POST['note'];
                $type = 'out';
                $dbdate = date('Y-m-d', $date);
                $res = Logistic::add($dbdate,$type,$point,$address,$ostatok,$note);
            }
            header ("location:". $_SERVER['REQUEST_URI']);
        }
//        addIn вручную сможет добавлять только логист-бухгалтер
        if(isset($_POST['addIn'])){
                $point = $_POST['point'];
                //проверка на доступность добавления
                // if(in_array(mb_strtoupper($point,'UTF-8'),$providers)){
                    // $err = "Доставка НЕ была добавлена! Попробуйте через интерфейс снабжения!";
                // }else{
                $address = $_POST['address'];
                $ostatok = $_POST['sum'];
                $note = $_POST['note'];
                $type = 'in';
                $dbdate = date('Y-m-d', $date);
                $res = Logistic::add($dbdate,$type,$point,$address,$ostatok,$note);
            header ("location:". $_SERVER['REQUEST_URI']);
                    
                // }
        }

        //список водителей
        $drivers_list = Users::getUserByPost(18);
        $drivers = array(
            90=>'самовывоз',
            89=>'доставка'
        );
        foreach($drivers_list as $one){
            if($one['validation']==1){
                $drivers[$one['id']] = $one['name'];
            }
        }

        $day = date('d.m',$date);
        //список нужных закупок на дату
//        $materials = Material::getAllInfoDate($dbdate);
//        foreach($materials as $mater){
//            $points[$mater['prov_id']][] = $mater;
//        }
//        var_dump($materials);die;

//        if(isset($points)){
//            $summat = 0;
//            foreach($points as $provid=>$provlit){
//                $s = 0;
//                $ords = array();
//                foreach($provlit as $mat){
//                    $s += $mat['summ'];
//                    if(!in_array($mat['contract'],$ords))
//                        $ords[] = $mat['contract'];
//                }
//                $points[$provid]['s'] = $s;
//                $summat += $s;
//                $points[$provid]['ords'] = json_encode($ords);
//                $points[$provid]['name'] = $provlit[0]['provider'];
//                $points[$provid]['driver'] = $provlit[0]['driver'];
//                $points[$provid]['note'] = $provlit[0]['note'];
//                $points[$provid]['logist_id'] = $provlit[0]['logist_id'];
//            }
//        }

//        нужно включить оповещение о неуказанной сумме закупки

//var_dump($points);die;

        //список на дату
        $allist = Logistic::getLogistsByParam('date',$dbdate);
//        var_dump($allist);die;
// debug($allist);
        $listout = array();
        $listin = array();
        $sumout = 0;
        $sumin = 0;
        $summat = 0;
        foreach($allist as $one){
            if($one['type']=='out'){
                $order = Order::getOrderById($one['point']);
                $one['contract'] = $order['contract'];
                $one['address'] = $order['adress'];
                $one['summ'] = $order['sum'] - $order['prepayment'];
                $one['latlng'] = $order['latlng'];
                if(!Datas::isRekl($order['contract'])){
                    $sumout += $order['sum'];
                }
                $listout[] = $one;
            }else if($one['type']=='in'){
                if(is_numeric($one['point'])){
                    $summat += $one['summ'];
                    //залезть в материалы, проверить сумму
                    $matforlog = Material::getMaterialsByLogist($one['id']);
                    $ks = 0;
                    foreach ($matforlog as $itemmat){
                        if(empty($itemmat['summ'])){
                           $ks++;
                        }
                    }
                    if($ks>0){
                        $one['error'] = "У " . $ks . " из позиций не указана сумма";
                    }
                    //перезаписать point
                    // debug($providers);
                    $one['pointid'] = $one['point'];
                    $one['address'] = $providers[$one['point']]['address'];
                    $one['point'] = $providers[$one['point']]['name'];
                    $one['auto'] = 1;//пометить автоматически сформированные
                }else{
                    $sumin += $one['summ'];
                }
                $listin[] = $one;

            }
        }
        // debug($listin);
        $percent = $sumout*0.3;
        $style = '<link rel="stylesheet" href="/css/logist.css" title="normal" type="text/css" media="screen" />';
        $script = '<script type="text/javascript" src="/scripts/logistic.js"></script>';
            $page = SITE_PATH . 'views/logistic2.php';

        if(isset($_GET['printveaw'])){
            if($_GET['printveaw']==1){
                //сортируем по водителям
//        var_dump($listin); die;
                $listprint = array();
                foreach ($listin as $oneaddress){
                    if($oneaddress['driver'] != 0 && $oneaddress['driver'] != 90 && $oneaddress['driver'] != 89){
                        $listprint[$oneaddress['driver']][] = $oneaddress;
                    }
                }
                include(SITE_PATH . 'views/logisticprint.php');
            }elseif($_GET['printveaw']==2){
                //сортируем по водителям
//        var_dump($listout); die;
                $listprint = array();
                foreach ($listout as $oneaddress){
                    if($oneaddress['driver'] != 0 && $oneaddress['driver'] != 90 && $oneaddress['driver'] != 89){
                        $listprint[$oneaddress['driver']][] = $oneaddress;
                    }
                }
                include(SITE_PATH . 'views/logdelivprint.php');
            }
        }else{
            include(SITE_PATH . 'views/layout.php');
        }

        return true;
    }
    function actionIndex2($date=null){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        if(isset($_GET['date'])&&$_GET['date']!='') $date = $_GET['date'];
        $date = $date==null?strtotime('today'):$date;
        $dbdate = date('Y-m-d', $date);
        $ost_in = 0;

        if(isset($_POST['addOut'])){
            if(!empty($_POST['point'])){
                $point = $_POST['point'];
                $address = $_POST['address'];
                $ostatok = $_POST['ostatok'];
                $note = $_POST['note'];
                $type = 'out';
                $dbdate = date('Y-m-d', $date);
                $res = Logistic::add($dbdate,$type,$point,$address,$ostatok,$note);
            }
            header ("location:". $_SERVER['REQUEST_URI']);
        }

        if(isset($_POST['addIn'])){
                $point = $_POST['point'];
                $address = $_POST['address'];
                $ostatok = $_POST['sum'];
                $note = $_POST['note'];
                $type = 'in';
                $dbdate = date('Y-m-d', $date);
                $res = Logistic::add($dbdate,$type,$point,$address,$ostatok,$note);
            header ("location:". $_SERVER['REQUEST_URI']);
        }

        //список водителей
        $drivers_list = Users::getUserByPost(18);
        $drivers = array(
            90=>'самовывоз',
            89=>'доставка'
        );
        foreach($drivers_list as $one){
            if($one['validation']==1){
                $drivers[$one['id']] = $one['name'];
            }
        }
        $day = date('d.m',$date);
        //список на дату
        $allist = Logistic::getLogistsByParam('date',$dbdate);
        $listout = array();
        $listin = array();
        $sumout = 0;
        $sumin = 0;
        foreach($allist as $one){
            if($one['type']=='out'){
                $order = Order::getOrderById($one['point']);
                $one['contract'] = $order['contract'];
                $one['latlng'] = $order['latlng'];
                if(!Datas::isRekl($order['contract'])){
                    $sumout += $order['sum'];
                }
                $listout[] = $one;
            }else{
                $listin[] = $one;
                $sumin += $one['summ'];
            }
        }
        $percent = $sumout*0.3;
//        var_dump($listout); die;

        $style = '<link rel="stylesheet" href="/css/logist.css" title="normal" type="text/css" media="screen" />';
        $script = '<script type="text/javascript" src="/scripts/logistic.js"></script>';
            $page = SITE_PATH . 'views/logistic.php';

        if(isset($_GET['printveaw'])){
            if($_GET['printveaw']==1){
                //сортируем по водителям
//        var_dump($listin); die;
                $listprint = array();
                foreach ($listin as $oneaddress){
                    if($oneaddress['driver'] != 0 && $oneaddress['driver'] != 90 && $oneaddress['driver'] != 89){
                        $listprint[$oneaddress['driver']][] = $oneaddress;
                    }
                }
                include(SITE_PATH . 'views/logisticprint.php');
            }elseif($_GET['printveaw']==2){
                //сортируем по водителям
//        var_dump($listout); die;
                $listprint = array();
                foreach ($listout as $oneaddress){
                    if($oneaddress['driver'] != 0 && $oneaddress['driver'] != 90 && $oneaddress['driver'] != 89){
                        $listprint[$oneaddress['driver']][] = $oneaddress;
                    }
                }
                include(SITE_PATH . 'views/logdelivprint.php');
            }
        }else{
            include(SITE_PATH . 'views/layout.php');
        }
        return true;
    }

    function actionMaps(){
        include(SITE_PATH . 'views/googleMaps.php');
        return true;
    }
    function actionGetOrderList(){

        $date = $_POST['date'];
        $dbdate = date('Y-m-d', $date);
        $list = OrderStan::getPlanOtgruz($dbdate);
        echo json_encode($list);
//        echo $dbdate;
        return true;
    }

    function actionGetOrderInfo(){

        $oid = $_POST['oid'];
        $list = Order::getOrderById($oid);
        //проверка рекламации
        $rekl = Datas::isRekl($list['contract']);
        $list['rekl'] = $rekl;
        echo json_encode($list);

        return true;
    }

    function actionUpdateProvidersAddress(){
        $id = $_POST['provid'];
        $val = $_POST['address'];
        $res = Providers::updateParam($id, 'address', $val);
        echo $res;
        
        return true;
    }
    
    function actionDelete(){

        $lid = $_POST['lid'];
        $res = Logistic::delLogistById($lid);

        echo $res;

        return true;
    }
    function actionUpdate(){

        $lid = $_POST['lid'];
        $logauto = $_POST['logauto'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $res = Logistic::updateLogistByParam('date',$date,$lid);
        if($logauto==1){
            Material::updateParamByLogist($lid,'plan_date',$date);
        }

        echo $res;

        return true;
    }

    function actionUpdateInfo(){
        $oid = $_POST['oid'];
        $point = $_POST['point'];
        $addr = $_POST['addr'];
        $note = $_POST['lognote'];

        $res1 = Logistic::updateLogistByParam('note', $note, $oid);
        $res2 = Logistic::updateLogistByParam('point', $point, $oid);
        $res3 = Logistic::updateLogistByParam('address', $addr, $oid);
        $res = $res1 && $res2 && $res3;

        echo $res;
        return true;
    }

    function actionCheckForRename(){
        $p = $_POST['point'];
        $providers = Providers::getAllProviders();
                //проверка на доступность добавления
        echo in_array(mb_strtoupper($p,'UTF-8'),$providers);
        return true;
    }
    function actionUpdateDriver(){

        $lid = $_POST['lid'];
        $uid = $_POST['uid'];
        $res = Logistic::updateLogistByParam('driver',$uid,$lid);

        echo $res;

        return true;
    }

    function actionChangeSum(){

        $lid = $_POST['lid'];
        $sum = $_POST['sum'];
        $res = Logistic::updateLogistByParam('summ',$sum,$lid);

        echo $res;

        return true;
    }
    function actionChangeNote(){

        $lid = $_POST['lid'];
        $note = $_POST['note'];
        $res = Logistic::updateLogistByParam('note',$note,$lid);

        echo $res;

        return true;
    }
}
?>
