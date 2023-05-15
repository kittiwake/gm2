<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.10.2015
 * Time: 20:39
 */

class Controller_new {
    function actionIndex()
    {

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allow = Allowed::getAllowed('new','Index');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $contract='';
        $con_date='';
        $ooo = '';
        $name = '';
        $prod = '';
        $termin = '';
        $d = 0;
        $otkr = 0;
        $sum = '';
        $rassr = 0;
        $beznal = 0;
        $pred = '';
        $dis ='';
        $agreement ='disagree';
        $adress = '';
        $phone = '';
        $email = '';
        $note = '';
        $rebate = '';
        $sumdeliv = '';
        $sumcollect = '';

        //получить список дизайнеров
        $userList = User_post::getUsersByPost(5);
        $disList = array();
        foreach ($userList as $disid){
            $datadis = Users::getUserById($disid['uid']);
            if($datadis['validation'] == 1){
                $disList[] = array('uid' => $datadis['id'], 'name' => $datadis['name']);
            }
        }
    //    var_dump($disList);


        if(isset($_POST['submit'])) {

            //текстовые поля
            if (isset($_POST['num'])) {
                $contract = $_POST['num'];
                if(substr($contract,0,3) == 'Р-'){
                    $contract = 'Р'.substr($contract,3);
                }
            }
            if (isset($_POST['con_date'])) {
                $con_date = $_POST['con_date'];
            }
            if (isset($_POST['name'])) {
                $name = $_POST['name'];
            }
            if (isset($_POST['prod'])) {
                $prod = $_POST['prod'];
            }
            if (isset($_POST['term'])) {
                $termin = $_POST['term'];
                $term = Datas::checkSunday($termin);
                $plan = $term;
            }
            if(isset($_POST['calday'])){
                $d = $_POST['calday'];
            }
            if (isset($_POST['sum'])) {
                $sum = str_replace(",", ".", $_POST['sum']);
            }
            if (isset($_POST['pred'])) {
                $pred = str_replace(",", ".", $_POST['pred']);
            }
            if (isset($_POST['sumdeliv'])) {
                $sumdeliv = str_replace(",", ".", $_POST['sumdeliv']);
            }
            if (isset($_POST['sumcollect'])) {
                $sumcollect = str_replace(",", ".", $_POST['sumcollect']);
            }
            if(isset($_POST['rebate'])){
                $rebate = $_POST['rebate'];
            }
            if (isset($_POST['adress'])) {
                $adress = $_POST['adress'];
            }
            if (isset($_POST['phone'])) {
                $phone = $_POST['phone'];
            }
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
            }
            if (isset($_POST['note'])) {
                $note = $_POST['note'];
            }
//чекбоксы
            if (isset($_POST['beznal'])&& $_POST['beznal'] != '') {
                $beznal = 1;
            }
            if (isset($_POST['otkr']) && $_POST['otkr'] != '') {
                $otkr = 1;
                $term = '0000-00-00';
            }
            if (isset($_POST['rassr'])&& $_POST['rassr'] != '') {
                $rassr = 1;
            }
            if (isset($_POST['agreement'])&& $_POST['agreement'] != '') {
                $agreement = 'agree';
            }
//селект
            if(isset($_POST['dis'])){
                $dis = $_POST['dis'];
            }
            if(isset($_POST['ooo'])){
                $ooo = $_POST['ooo'];
            }



            $errors = false;
            if (!Datas::checkPole($contract)) {
                $errors[] = 'Не введен номер заказа';
            }
            if (!Datas::checkPole($ooo)) {
                $errors[] = 'Укажите ООО';
            }

            if (!Datas::checkPole($name)) {
                $errors[] = 'Как обращаться к заказчику?';
            }
            if (!Datas::checkPole($termin) && $otkr == 0) {
                if(isset($_POST['calday']) && $_POST['calday'] != ''){
                    $d = $_POST['calday'];
                    $cdate = strtotime($con_date);
                    $tterm = strtotime('+' . $d . ' days', $cdate);
                    $termin = date("d-m-Y", $tterm);
                    $term = Datas::checkSunday($termin);
                    $plan = $term;
                }
                else{
                    $errors[] = 'Не указан срок договора';
                }
            }
            if (!Datas::checkPole($sum)) {
                $errors[] = 'Укажите сумму договора';
            }
            if($rebate == ''){
                $errors[]='Укажите скидку';
            }
            if (!Datas::checkPole($phone)) {
                $errors[] = 'Введите номер телефона';
            }

            $dubl = Order::getOrdersByParam('contract',$contract);
            if (!empty($dubl)){
                $errors[] = 'Уже есть заказ с таким номером';
            }

            $result = NULL;
            if (!$errors) {
                if(!(strpos($rebate,"%")===false)){
                    $rebate = explode('%', $rebate)[0];
                    if($rebate==''){
                        $rebate = 0;
                    }else{
                        $rebate = intval($sum/(100-$rebate)*$rebate);
                    }
                }
                //вносим в базу
                $result = Order::add($contract, $con_date, $name, $prod, $adress, $phone, $term, $dis, $sum, $pred, $rassr, $beznal, $email,$agreement,$rebate,$sumdeliv,$sumcollect,$ooo);
                if(!empty($result)){
                    OrderStan::add($result, $plan);
                    if($note != ''){
                        Notes::setNote($result, $note);
                    }
                }

            }
        }
        if(isset($_GET['update'])){
            echo "заменим";die;
        }

        $page = SITE_PATH.'views/new.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    function actionTest()
    {
                    $d = 6;
                    // $date = date("d-m-Y", mktime(0, 0, 0, date('m',$con_date), date('d',$con_date) - 3, date('Y',$con_date)));
                    $cdate = strtotime('29-01-2020');
                    $delta = strtotime('+' . $d . ' days', $cdate);
                    // $delta = strtotime($d . ' days');

                    // echo date('Y-m-d', $date);
                    $dt = date("d-m-Y", $delta);
                    echo ($dt);
        return true;
    }

    function actionCheckDublication($con)
    {
        if(substr($con,0,3) == 'Р-'){
            $con = 'Р'.substr($con,3);
        }
        $dubl = Order::getOrdersByParam('contract',$con);

        if (!empty($dubl)){
//            echo 'Уже есть заказ с таким номером';
            echo json_encode($dubl);
        }
        return true;
    }

    function actionCall()
    {
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allow = Allowed::getAllowed('new','Call');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        //получить список дизайнеров
        $userList = User_post::getUsersByPost(5);
        $disList = array();
        foreach ($userList as $disid){
            $datadis = Users::getUserById($disid['uid']);
            if($datadis['validation'] == 1){
                $disList[] = array('uid' => $datadis['id'], 'name' => Datas::nameAbr($datadis['name']));
            }
        }
        $contract = '';
        $termin = '';
        $dis ='';
        $adress = '';
        $empt = '';
        $time = '';
        $note = '';
        $name_men = $log;

        if(isset($_POST['submit'])) {
//            //текстовые поля
            if (isset($_POST['con'])) {
                $contract = $_POST['con'];
            }
            if (isset($_POST['term'])) {
                $termin = $_POST['term'];
            }
            if (isset($_POST['adress'])) {
                $adress = $_POST['adress'];
            }
            if (isset($_POST['note'])) {
                $note = $_POST['note'];
            }
            if (isset($_POST['note'])) {
                $time = $_POST['time'];
            }
            $notedb = $time.'. '.$note;
            if (isset($_POST['empt'])) {
                $empt = $_POST['empt'];
            }
            if (isset($_POST['name_men'])) {
                $name_men = $_POST['name_men'];
            }
//селект
            if(isset($_POST['dis'])){
                $dis = $_POST['dis'];
            }
//
//
            $errors = false;
            if (!Datas::checkPole($contract)) {
                $errors[] = 'Не введен номер заказа';
            }
            if (!Datas::checkPole($termin)) {
                $errors[] = 'Не назначена дата';
            }
//
            $result = NULL;
            if (!$errors) {
                //вносим в базу
                $result = Plan_dis::addNew($contract, $adress, $termin,$dis,$notedb,$empt,$name_men);
            }
        }

        $page = SITE_PATH.'views/new_call.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionCheckArhiv($con)
    {
        $dubl = Plan_dis::getSamplesByParam('contract',$con);

        if (!empty($dubl)){
//            echo 'Уже есть заказ с таким номером';
            foreach($dubl as $key=>$sample){
                $users = Users::getUserById($sample['dis']);
                $designer = $users['name'];
                $dubl[$key]['designer'] = $designer;
                $date_html = date('d.m.y', strtotime($sample['date_dis']));
                $dubl[$key]['designer'] = $designer;
                $dubl[$key]['date_dis'] = $date_html;
            }

            echo json_encode($dubl);
        }
        return true;
    }

    function actionGetDisList(){
        $userList = User_post::getUsersByPost(5);
        $disList = array();
        foreach ($userList as $disid){
            $datadis = Users::getUserById($disid['uid']);
            if($datadis['validation'] == 1){
                $disList[] = array('uid' => $datadis['id'], 'name' => Datas::nameAbr($datadis['name']));
            }
        }
        echo json_encode($disList);

        return true;
    }
    
//     function actionCheckGM(){
//         $str = $_POST['con'];
//         $r = preg_replace('/[\W]/u',"%",$str);
//  //                               debug($r);

//         $arr = Order::getOrdersLikeParam('contract', $r);
//   //      var_dump($arr);
//         if(count($arr) < 1000 && count($arr)>0){
//             echo '1';
//         }else{
//  //           var_dump($arr);
//             echo '0';
//         }
        
//         return true;
//     }

    function actionOldi()
    {
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allow = Allowed::getAllowed('new','Oldi');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
        if(isset($_GET['con'])){
/*  [route] => new/oldi
    [с] => gm
    [t] => Эмаль
    [o] => 8301
    [con] => 25-761
    [d] => 2019-10-03
    [p] => 2019-10-16
)*/
            $contract = $_GET['con'];
            $dcon = $_GET['d'];
            $tip = $_GET['t']=='ПВХ'?1:2;
            $dil = 13;
            $term = $_GET['p'];
            $name_dil = 'Галерея Мебели';
            $phone_dil = 0;
            $gm=1;
            //искать заказ, и если дубликат, то переименовать их и добавить скобки(1/5)
            $list = Oldi::checkContractExist($contract);
            debug($list);
            $c = count($list)+1;
            
            if($c!=1){
                foreach($list as $k=>$one){
                    $oidd = $one['id'];
                    $k++;
                    $newcon = $contract.'('.$k.'/'.$c.')'; 
                    debug($newcon);
                }
                $contract = $contract.'('.$c.'/'.$c.')';
            }
            
        }
        else{
            $contract = '';
            $dcon = '';
            $tip = '';
            $dil = '';
            $term = '';
            $name_dil = '';
            $gm=0;
            //получить список диллеров
            $dillist = Oldi::getActiveDillers();
            
        }
        $mkv = '';
        $sum = '';
        $predopl = '';
        $color = '';
        $radius = '';
        $beznal = '';
        $pokr = '';
        $dopef = '';
        $fotopec = '';
        $note = '';
        $oldnum = '';

        $rad = 0;
        $fp = 0;
        $bezn = 0;

//        $phone_dil = '';
        $rw = 1;
        $result = false;

        if(isset($_POST['submit'])){

            $rw = $_POST['rw']+1;

            if(isset($_POST['con'])){
                $contract = $_POST['con'];
            }
            if(isset($_POST['lastolnum'])&&$_POST['lastolnum']!=''){
                $oldnum = $_POST['lastolnum'];
                $newnum = $_POST['num'];
                if($newnum > $oldnum){
                    $lastnum = $newnum;
                }
                else{
                    $lastnum = $oldnum;
                }
            }
            else{
                $lastnum = 1;
            }
            if(isset($_POST['dcon'])){
                $dcon = $_POST['dcon'];
                if(!Datas::checkPole($dcon)){
                    $dcon = date("d-m-Y", strtotime("today"));
                }
            }
            if(isset($_POST['tip'])){
                $tip = $_POST['tip'];
            }
            if(isset($_POST['mkv'])){
                $mkv = str_replace(',','.',$_POST['mkv']);
            }
            if(isset($_POST['sum'])){
                $sum = $_POST['sum'];
            }
            if(isset($_POST['predopl'])){
                $predopl = $_POST['predopl'];
            }
            if(isset($_POST['color'])){
                $color = $_POST['color'];
            }
            if(isset($_POST['radius'])){
                $radius = $_POST['radius'];
                $rad = 1;
            }
            if(isset($_POST['beznal'])){
                $beznal = $_POST['beznal'];
                $bezn = 1;
            }
            if(isset($_POST['pokr'])){
                $pokr = $_POST['pokr'];
            }
            if(isset($_POST['defpvh']) && $tip == 1){
                $dopef = $_POST['defpvh'];
            }
            if(isset($_POST['defemal']) && $tip == 2){
                $dopef = $_POST['defemal'];
            }
            if(isset($_POST['fotopec'])){
                $fotopec = $_POST['fotopec'];
                $fp = 1;
            }
            if (isset($_POST['term'])) {
                $termin = $_POST['term'];
                $term = Datas::checkSunday($termin);
            }
            if(isset($_POST['nameDil'])){
                $name_dil = $_POST['nameDil'];
            }
            if(isset($_POST['phoneDil'])){
                $phone_dil = $_POST['phoneDil'];
            }
            if(isset($_POST['idDil'])){
                $dil = $_POST['idDil'];
            }

            if(isset($_POST['note']) && $_POST['note']!=''){
                $note = '<p><b>'.date('d.m.Y').'</b> '.$_POST['note'].'</p>';
            }

            $errors = false;

            if(!Datas::checkPole($contract)){
                $errors[] = 'Не введен номер заказа';
            }else{
                $list = Oldi::checkContractExist($contract);
                debug($list);
                $c = count($list)+1;
                
                if($c!=1){
                    $errors[] = 'Заказ с данным номером уже существует';
                }
            }
            if(!Datas::checkPole($sum)){
                $errors[] = 'Введите стоимость заказа';
            }
            if(!Datas::checkPole($tip)){
                $errors[] = 'Не указан тип фасадов';
            }
            if(!Datas::checkPole($mkv)){
                $errors[] = 'Введите квадратуру';
            }

            if(!Datas::checkPole($term)){
                $errors[] = 'Не указан крайний срок заказа';
            }
            if($_POST['selectdil'] == 1){
                if(!Datas::checkPole($name_dil)){
                    $errors[] = 'Нет иформации о заказчике';
                }else{
                    //внести заказчика в базу
                    //определить id
                    $dil = Oldi::addCustomer($name_dil, $phone_dil);
                    if(!isset($dil) || $dil = 0){
                        $errors[] = 'Нет иформации о заказчике';
                    }
                }
            }

            if (!$errors){
                if($gm==1){
                    $list = Oldi::checkContractExist($_GET['con']);
                    $c = count($list)+1;
                }
                $gmid = $gm==1?$_GET['o']:0;
                $oid = Oldi::add($contract, $tip, $dcon, $mkv, $sum, $predopl, $bezn, $color, $rad, $pokr, $dopef, $fp, $term,$dil,$note,$gmid);
                //проверка корректности дат
                $res = Oldi::getOrderById($oid);
                
                $dbterm = strtotime($res['term']);
                $dbplan = strtotime($res['plan']);
                $today = strtotime('today');
                $maxterm = strtotime('today +3 month');
                if($dbterm<$today || $dbplan<$today || $dbterm>$maxterm || $dbplan>$maxterm){
                    $errors[] = 'Заказ не был добавлен. Перегрузите страницу и попробуйте снова';
                    $del = Oldi::delOrderById($oid);
                }else{
                    $result = true;
                }
                //вносим новый номер в таблицу заказчиков
                if($_POST['selectdil'] > 1 && $gm != 1){
                    $cid = $_POST['selectdil'];
                    $res = Oldi::updateCustomerByParam('lastnum', $lastnum, $cid);
                }
                if($c!=1 && $gm==1){
                    foreach($list as $k=>$one){
                        $oidd = $one['id'];
                        $k++;
                        $newcon = $_GET['con'].'('.$k.'/'.$c.')'; 
                        $res = Oldi::updateOrderByParam('contract',$newcon,$oidd); 
                    }
                }
            }


        }

   //     include_once (ROOT.'/views/neworder.php');
        $script = '<script type="text/javascript" src="/scripts/oldi.js"></script>';
        $page = SITE_PATH.'views/newoldi.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }
    
    function actionCheckDublOldi(){
        $contract = $_POST['con'];
        
        $list = Oldi::checkContractExist($contract);
       // debug($list);
        $c = count($list)+1;
        
        if($c!=1){
            foreach($list as $k=>$one){
                $oidd = $one['id'];
                $k++;
                $newcon = $contract.'('.$k.'/'.$c.')'; 
     //           debug($newcon);
            }
            $contract = $contract.'('.$c.'/'.$c.')';
        }
        echo $contract;
        return true;
    }
    
}