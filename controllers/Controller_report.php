<?php

class Controller_report
{
    function actionAssembly()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Assembly');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';

        if (isset ($_POST['submit'])) {
            if (isset($_POST['begin']) && isset($_POST['end'])) {
                $dataot = $_POST['begin'];
                $datapo = $_POST['end'];
                $begin = Datas::dateToDb($_POST['begin']);
                $end = Datas::dateToDb($_POST['end']);

                $odderList = array();//закрытые заказы
                $beznal = array();
                $coll = array();
                $rekl = array();
                $dillerskie = array();
                $dontclose=array();
                //список диллерских инициалов
                $dil = Dillers::getAllDillers();

                $list = OrderStan::getOrdersByPeriod($begin,$end,'sborka_end_date');


                foreach ($list as $one) {
                    $order = Order::getOrderById($one['oid']);
                    if($order) {
                        $colls = Mounting::getMountingLast($one['oid']);
                        $order['sborka_end_date'] = $one['sborka_end_date'];
                        foreach($colls as $onecoll){
                            if($order['beznal']==1 || $order['rassr']==1){
                                $beznal[$onecoll['uid']][] = $order;
                            }elseif(Datas::isRekl($order['contract'])){
                                $rekl[$onecoll['uid']][] = $order;
                            }else{
                                $d = false;
                                foreach($dil as $onedil){
                                    //найти подстроку в номере договора
                                    $pos = strpos($order['contract'],$onedil['flag']);
                                    if($pos!==false&&$pos==0){
                                        $d = true;
                                    }
                                }
                                if($d){
                                    $dillerskie[$onecoll['uid']][] = $order;
                                }else{
                                    $odderList[$onecoll['uid']][] = $order;
                                }
                            }
                        }

                    }
                }
//                foreach ($list as $one) {
//                    $order = Order::getOrderById($one['oid']);
//                    if($order) {
//                        $colls = Mounting::getMountByOidDate($one['oid'],$one['sborka_end_date']);
//
//                        $order['sborka_end_date'] = $one['sborka_end_date'];
//                        //выделить безнал и рекламации
//                        if($order['beznal']==1 || $order['rassr']==1){
//                            $beznal[$order['collector']][] = $order;
//                        }elseif(Datas::isRekl($order['contract'])){
//                            $rekl[$order['collector']][] = $order;
//                        }else{
//                            $d = false;
//                            foreach($dil as $onedil){
//                                //найти подстроку в номере договора
//                                $pos = strpos($order['contract'],$onedil['flag']);
//                                if($pos!==false&&$pos==0){
//                                    $d = true;
//                                }
//                            }
//                            if($d){
//                                $dillerskie[$order['collector']][] = $order;
//                            }else{
//                                $odderList[$order['collector']][] = $order;
//                            }
//                        }
//                    }
//                }
            }
        }
        //список всех сборщиков
        $coll = array();
        $idusers = User_post::getUsersByPost(17);
        foreach ($idusers as $id) {
            $user = Users::getUsersByParam('id',$id['uid']);
            $coll[$user[0]['id']] = $user[0]['name'];
            //незакрытые заказы
            $dontclose[$id['uid']] = OrderStan::getNeSobr($id['uid']);
      }

        $page = SITE_PATH . 'views/repsb.php';
        include(SITE_PATH . 'views/layout.php');

        return true;
    }

    function actionAveturnover()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Aveturnover');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $year = date('Y');
        $month = date('n'); //Порядковый номер месяца без ведущих нулей
        $arr = array();
        $rekl = array();
        $allsum = 0;
        $int = ($year-2014)*12+($month-7)+1;
        for($i=0; $i<$int; $i++){
            $arr[$i] = Order::getNeRekl($i);
            $rekl[$i] = Order::getRekl($i);
            $allsum += $arr[$i]['SUM(sum)'];

        }
        $sredn = round ($allsum/$int);

        $dataot = '';
        $datapo = '';

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $orderList = Order::getPlanByPeriod($dataot, $datapo);
                $dillList = array();
                $sum = 0;
                $count =0;
                $claimsum = 0;
                $sumdil = 0;
                $countdil =0;
                $claimsumdil = 0;
                foreach($orderList as $key=>$order){
                    if(Datas::isDillers($order['contract'])){
                        if(Datas::isRekl($order['contract'])){
                            $orderList[$key]['style'] = 'style="background-color: #f5a185;"';
                            $claimsumdil += $order['sum'];
                        }else{
                            $countdil++;
                            $sumdil += $order['sum'];
                            $orderList[$key]['style'] = '';
                        }
                        $dillList[] = $orderList[$key];
                        unset($orderList[$key]);
                    }
                    else{
                        if(Datas::isRekl($order['contract'])){
                            $orderList[$key]['style'] = 'style="background-color: #f5a185;"';
                            $claimsum += $order['sum'];
                        }else{
                            $count++;
                            $sum += $order['sum'];
                            $orderList[$key]['style'] = '';
                        }
                    }
                }
                if($claimsum!=0)$pers = round($claimsum/$sum*100);
                if($claimsumdil!=0)$persdil = round($claimsumdil/$sumdil*100);
                else $pers = 0;
            }
        }

        $page = SITE_PATH . 'views/repaveturnover.php';
        include(SITE_PATH . 'views/layout.php');

        return true;
    }

    function actionTechnologist(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Technologist');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';

        //список заказов, просчианных технологами и еще не вывезенные
        //список заказов непросчитанных и невывезенных
        $sumtech2 = 0; //считанные
        $sumtech0 = 0; //несчитанные
        $numrekl2 = 0; // рекламации
        $numrekl0 = 0; // рекламации
        $numtech0 = 0;
        $numtech2 = 0;

        //На данный момент просчитано $numtech2 заказов на сумму $sumtech2. сдано $numrekl2 рекламаций
        // В планах еще $numtech0 заказов на сумму $sumtech0. Сдать $numrekl0 рекламаций

        $fromtoday = OrderStan::getReportFromToday();
        foreach ($fromtoday as $repod){
            //`contract` , `plan` , `sum`, `tech_end`
            if($repod['tech_end']==2){
                if(Datas::isRekl($repod['contract'])){
                    $numrekl2++;
                }else{
                    $numtech2++;
                    $sumtech2 +=$repod['sum'];
                }
            }else{
                if(Datas::isRekl($repod['contract'])){
                    $numrekl0++;
                }else{
                    $numtech0++;
                    $sumtech0 +=$repod['sum'];
                }
            }
        }

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $techend_list = Order::getTechEndByPeriod($dataot, $datapo);
                foreach($techend_list as $name=>$list){
                    $sum[$name] = 0;
                    $count[$name] = 0;
                    foreach($list as $key=>$order){
                        $techend_list[$name][$key]['style'] = 'style="background-color: #f5a185;"';
                        if(!Datas::isRekl($order['contract'])){
                            $techend_list[$name][$key]['style'] = '';
                            $sum[$name] += $order['sum'];
                            $count[$name]++;
                        }
                    }
                }
            }
        }

        $page = SITE_PATH . 'views/reptech.php';
        include(SITE_PATH . 'views/layout.php');
        return true;
    }

    function actionIndex(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $dataot = '';
        $datapo = '';

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $orderList = Order::getOtgruzByPeriod($dataot, $datapo);
                $sum = 0;
                $count =0;
                $claims = 0;
                foreach($orderList as $key=>$order){
                    if(Datas::isRekl($order['contract'])){
                        $orderList[$key]['style'] = 'style="background-color: #f5a185;"';
                        $claims++;
                    }else{
                        $count++;
                        $sum += $order['sum'];
                        $orderList[$key]['style'] = '';
                    }
                }
            }
        }

        $page = SITE_PATH . 'views/repexport.php';
        include(SITE_PATH . 'views/layout.php');
        return true;
    }
    function actionExport(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Export');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $orderList = Order::getOtgruzByPeriod($dataot, $datapo);
                $sum = 0;
                $count =0;
                $claims = 0;
                foreach($orderList as $key=>$order){
                    if(Datas::isRekl($order['contract'])){
                        $orderList[$key]['style'] = 'style="background-color: #f5a185;"';
                        $claims++;
                    }else{
                        $count++;
                        $sum += $order['sum'];
                        $orderList[$key]['style'] = '';
                    }
                }
            }
        }

        $page = SITE_PATH . 'views/repexport.php';
        include(SITE_PATH . 'views/layout.php');
        return true;
    }

    function actionExpclaim(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Expclaim');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $orderList = Order::getOtgruzByPeriod($dataot, $datapo);
                $sum = 0;
                $count =0;
                foreach($orderList as $key=>$order){
                    if(Datas::isRekl($order['contract'])){
                        $sum += $order['sum'];
                        $count++;
                        $firstorder = preg_replace('/(.+)([РГД])([1-9р]?)/u', '\1', $order['contract']);
                        $infofirst = Order::getOrdersByParam('contract', $firstorder);
                        if($infofirst){
                            $techfirst = $infofirst[0]['technologist'];
                            $dis = $infofirst[0]['designer'];
                            $user = Users::getUserById($techfirst);
                            $techfirstname = $user['name'];
                            $user = Users::getUserById($dis);
                            $disfirst = $user['name'];
                            $orderList[$key]['techfirst'] = $techfirstname;
                            $orderList[$key]['dis'] = $disfirst;
                        }else{
                            $orderList[$key]['techfirst'] = null;
                            $orderList[$key]['dis'] = null;
                        }
                    }else{
                        unset($orderList[$key]);
                    }
                }
            }
        }

        $page = SITE_PATH . 'views/repexpclaim.php';
        include(SITE_PATH . 'views/layout.php');
        return true;
    }

    function actionSms($type='sms'){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Sms');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        $dataot = '';
        $datapo = '';

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $smsList = Sms::getSmsByPeriod($dataot, $datapo);
//                var_dump($smsList);die;
                foreach($smsList as $key=>$sms){
                    if($sms['contract']==null) unset($smsList[$key]);
                    if($sms['type']=='email'&& $type == 'sms') unset($smsList[$key]);
                    if($sms['type']=='sms'&& $type == 'email') unset($smsList[$key]);
                }
            }
        }
        $page = SITE_PATH . 'views/repsms.php';
        include(SITE_PATH . 'views/layout.php');
        return true;
    }

    function actionNP()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','NP');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';

        $dataot = '';
        $datapo = '';

        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $orderList = Order::getOtgruzByPeriod($dataot, $datapo);

                foreach($orderList as $key=>$order){
                    if(Datas::isRekl($order['contract'])){
                        unset($orderList[$key]);
                    }
                }
            }
        }

        $page = SITE_PATH . 'views/repNP.php';
        include(SITE_PATH . 'views/layout.php');

        return true;
    }

    function actionSample()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Sample');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

//if($ri == 20){
//    header('Content-Type: text/html; charset= CP866');
//}

        $dataot = '';
        $datapo = '';
        $disid = '';
        //список всех дизайнеров
        $dis = array();
        $disval = array();
        $idusers = User_post::getUsersByPost(5);
        foreach ($idusers as $id) {
            $user = Users::getUsersByParam('id',$id['uid']);
            if(isset($user[0]['id'])){
                $name =  Datas::nameAbr($user[0]['name']);
                $dis[$user[0]['id']] = $name;
                if($user[0]['validation']==1){
                    $disval[$user[0]['id']] = $name;
                }
            }
        }

        $statist = array();
        $itogo = array();

        if (isset ($_POST['submit'])) {
            if (isset($_POST['dataot']) && isset($_POST['datapo'])) {
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $disid = $_POST['disigner'];
                $begin = Datas::dateToDb($_POST['dataot']);
                $end = Datas::dateToDb($_POST['datapo']);

                $list = Plan_dis::getSamplesByPeriod($begin, $end);
                $itogo['vyezd'] = 0;
                $itogo['zakl'] = 0;
                $itogo['otkaz'] = 0;
                $itogo['summ'] = 0;
                $itogo['prep'] = 0;
                $itogo['ost'] = 0;
//                var_dump($list);die;
                foreach($list as $k=>$order){
//if($ri == 20){
//    $list[$k]['sum'] = round($order['sum']/3.5);
//    $list[$k]['prepayment'] = round($order['prepayment']/3.5,-3);
//}
                    if($order['dis']!=0){
                        if(!isset($statist[$order['dis']]['vyezd'])){
                            $statist[$order['dis']]['vyezd'] = 0;
                            $statist[$order['dis']]['zakl'] = 0;
                            $statist[$order['dis']]['otkaz'] = 0;
                            $statist[$order['dis']]['summ'] = 0;
                            $statist[$order['dis']]['prep'] = 0;
                            $statist[$order['dis']]['ost'] = 0;
                        }
                        $statist[$order['dis']]['vyezd'] += 1;
                        $itogo['vyezd'] += 1;
                        if($order['stan'] == 'zakluchen') {
                            $statist[$order['dis']]['zakl'] +=1;
                            $statist[$order['dis']]['summ'] += $order['sum'];
                            $statist[$order['dis']]['prep'] += $order['prepayment'];
                            $statist[$order['dis']]['ost'] += $order['sum']-$order['prepayment'];
                            $itogo['zakl'] +=1;
                            $itogo['summ'] += $order['sum'];
                            $itogo['prep'] += $order['prepayment'];
                            $itogo['ost'] += $order['sum']-$order['prepayment'];
                        }
                        if($order['stan'] == 'holiday') {
                            $statist[$order['dis']]['vyezd'] += -1;
                            $itogo['vyezd'] += -1;
                        }
                        if($order['stan'] == 'otkaz') {
                            $statist[$order['dis']]['otkaz'] += 1;
                            $itogo['otkaz'] += 1;
                        }
                    }
                }
            }
        }


//        var_dump($statist); die;

        $page = SITE_PATH . 'views/repsample.php';
        include(SITE_PATH . 'views/layout.php');

        return true;
    }

    function actionLogistic()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Logistic');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';

        $statist = array();
        $itogo = array();

        if (isset ($_POST['submit'])) {
            if (isset($_POST['dataot']) && isset($_POST['datapo'])) {
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $begin = Datas::dateToDb($_POST['dataot']);
                $end = Datas::dateToDb($_POST['datapo']);

                $listin = Logistic::getLogistInBy2Dates($begin,$end);
//                $listout = array();
//                $sumout = 0;
                $sumin = 0;
                foreach($listin as $one){
                        $sumin += $one['summ'];
                }
            }
        }
        //список водителей
        $drivers_list = Users::getUserByPost(18);
        $drivers = array(
            90=>'самовывоз',
            89=>'доставка'
        );
        foreach($drivers_list as $one){
            $drivers[$one['id']] = $one['name'];
        }

//        var_dump($statist); die;

        $page = SITE_PATH . 'views/replogist.php';
        include(SITE_PATH . 'views/layout.php');

        return true;
    }

    function actionMaterial(){
    
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('report','Material');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $dataot = '';
        $datapo = '';
//$orderList = OrderStan::getRaspilMaterials($dataot, $datapo);
        if(isset($_POST['submit'])){
            if(!empty($_POST['dataot']) && !empty($_POST['datapo'])){
                $dataot = $_POST['dataot'];
                $datapo = $_POST['datapo'];
                $orderList = OrderStan::getRaspilMaterials($dataot, $datapo);
                $sum = 0;
                foreach($orderList as $key=>$order){
                    $patterns = array ('/[\x3A-\xFF]+/',
                                        '/,/');
                    $replace = array ('', '.');
                    //echo preg_replace($patterns, $replace, '{startDate} = 1999-5-27');
                    
                    $count = preg_replace($patterns, $replace, $order['noteboss']);
                    $orderList[$key]['count'] = $count+0;
                    $sum += $count;
                }
            }
        }
        $page = SITE_PATH . 'views/repmater.php';
        include(SITE_PATH . 'views/layout.php');

        return true;
    }
}
