<?php

class Controller_delivery {

    function actionSchedule2(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,3,4,8,58,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $nW = 6;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600;
        $end = $begin+(2+$nW)*7*24*3600;

        $todW = date('W', strtotime('today'));
        
        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);
        
        $idList = Order::getOrdPlansByPeriod($first, $last);
        $olidList =  Oldi::getPlansByPeriod($first, $last);




        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $todW = date('W', strtotime('today'));
     //   $olidList =  Oldi::getPlansByPeriod($first, $last);
        
        // debug($olidList);die;
$mater = array();
$furn = array();
$oldi = array();
        foreach ($idList as $order){
            $key = strtotime($order['plan']);
            $nweek = date('W', strtotime($order['plan']))-$todW;
            $dweek = date('w', strtotime($order['plan']));

            $orderOne = Order::getOrderById($order['oid']);
            if(isset($orderOne['contract'])) {
                if (!Datas::isRekl($orderOne['contract'])) {
                    $delivList = Material::getOrderMaterial($order['oid']);
                    foreach($delivList as $point){
         //              debug($point); 
                        if($point['otdel']=='m'){
                            $mater[$order['oid']][]=$point;
                        }
                        if($point['otdel']=='f'){
                            $furn[$order['oid']][]=$point;
                        }
 /*                       if($point['otdel']=='o'){
                            $oldi[$order['oid']][]=$point;
                        }
 */                   }
                    $orderList[$key][$order['oid']] = $orderOne;
                    $orderList[$key][$order['oid']]['plan'] = $order['plan'];
                    $orderList[$key][$order['oid']]['tech_end'] = $order['tech_end'];
                    $orderList[$key][$order['oid']]['upak_end'] = $order['upak_end'];
                    $orderList[$key][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                }
            }
        }
// debug($orderList);
        foreach ($olidList as $olorder){
            $key = strtotime($olorder['plan']);
            $nweek = date('W', strtotime($olorder['plan']))-$todW;
            $dweek = date('w', strtotime($olorder['plan']));
                    $oid = $olorder['oid'];
                    $oldelivList = Material::getOrderMaterial($oid);
                    foreach($oldelivList as $point){
         //              debug($point); 
                        if($point['otdel']=='o'){
                            $oldi[$olorder['oid']][]=$point;
                        }
                    }
                    $olorderList[$key][$oid] = $olorder;
                    $olorderList[$key][$oid]['tech_end'] = $olorder['v_ceh'];
                    $olorderList[$key][$oid]['upak_end'] = $olorder['upak'];
                    $olorderList[$key][$oid]['otgruz_end'] = $olorder['otgruz'];

        }
// debug($oldi);
//if($ri == 1){
 //  debug($mater);
 //  die;
//}
$providers = array();
$providers = Providers::getActiveProviders();

//получить все сметы
$outlays = array();
$outlays = Outlay::getOutlaysNoEnd();


        $style = '<link rel="stylesheet" href="/css/delivery.css" title="normal" type="text/css">';
        $page = SITE_PATH.'views/deliveryschedule.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    
    function actionSchedule(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allow = Allowed::getAllowed('delivery','Schedule');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $nW = 6;
        $today = strtotime('today');
        $todW = date('W', $today);
        $w = date('w', $today);

        $begin = $today-$w*24*60*60-7*24*3600;
        $end = $begin+(2+$nW)*7*24*3600;

        $todW = date('W', strtotime('today'));
        
        $first =  date('Y-m-d', $begin);
        $last =  date('Y-m-d', $end);
        
        $idList = Order::getOrdPlansByPeriod($first, $last); // список с рекламациями
        $olidList =  Oldi::getPlansByPeriod($first, $last);



        //получить список id заказов в диапазоне дат
        $idList = OrderStan::getOrdersByPeriod($first, $last);
        $todW = date('W', strtotime('today'));
     //   $olidList =  Oldi::getPlansByPeriod($first, $last);
// var_dump($idList);        
        // debug($olidList);die;
$mater = array();
$furn = array();
$oldi = array();
        foreach ($idList as $order){
            $key = strtotime($order['plan']);
            $nweek = date('W', strtotime($order['plan']))-$todW;
            $dweek = date('w', strtotime($order['plan']));

            $orderOne = Order::getOrderById($order['oid']);
            if(isset($orderOne['contract'])) {
                
                // if (!Datas::isRekl($orderOne['contract'])) {
                
                    $delivList = Material::getOrderMaterial($order['oid']);
                    foreach($delivList as $point){
         //              debug($point); 
                        if($point['otdel']=='m'){
                            $mater[$order['oid']][]=$point;
                        }
                        if($point['otdel']=='f'){
                            $furn[$order['oid']][]=$point;
                        }
 /*                       if($point['otdel']=='o'){
                            $oldi[$order['oid']][]=$point;
                        }
 */                   }
                    $orderList[$key][$order['oid']] = $orderOne;
                    $orderList[$key][$order['oid']]['plan'] = $order['plan'];
                    $orderList[$key][$order['oid']]['tech_end'] = $order['tech_end'];
                    $orderList[$key][$order['oid']]['upak_end'] = $order['upak_end'];
                    $orderList[$key][$order['oid']]['otgruz_end'] = $order['otgruz_end'];
                // }
            }
        }
// debug($orderList);
        foreach ($olidList as $olorder){
            $key = strtotime($olorder['plan']);
            $nweek = date('W', strtotime($olorder['plan']))-$todW;
            $dweek = date('w', strtotime($olorder['plan']));
                    $oid = $olorder['oid'];
                    $oldelivList = Material::getOrderMaterial($oid);
                    foreach($oldelivList as $point){
         //              debug($point); 
                        if($point['otdel']=='o'){
                            $oldi[$olorder['oid']][]=$point;
                        }
                    }
                    $olorderList[$key][$oid] = $olorder;
                    $olorderList[$key][$oid]['tech_end'] = $olorder['v_ceh'];
                    $olorderList[$key][$oid]['upak_end'] = $olorder['upak'];
                    $olorderList[$key][$oid]['otgruz_end'] = $olorder['otgruz'];

        }
// debug($oldi);
//if($ri == 1){
 //  debug($mater);
 //  die;
//}


        $style = '<link rel="stylesheet" href="/css/delivery.css" title="normal" type="text/css">';
        $page = SITE_PATH.'views/deliveryscheduledemo.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionOrder($oid){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('delivery','Order');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
        // debug($_GET);
    $otd = (isset($_GET['otd'])&&$_GET['otd']!='undefined')?$_GET['otd']:'m';
    if($otd == 'o'){
        //ищем заказ в таблице олди
        $order = Oldi::getOrderById($oid);
 //       debug($order);
        $contract = $order['contract'];
//         $iddis = $order['designer'];
//         $idtech = $order['technologist'];
//         $infodis = Users::getUserById($iddis);
//         $dis = $infodis['name'];
//         $infotech = Users::getUserById($idtech);
//         $tech = $infotech['name'];
$tech = '';
$dis = '';
//         //суммы
        $summ = $order['sum'];
        $prepayment = $order['prepayment'];
        
        // переделать пересчет с учетом ГМ
        $limit = $summ*0.3;
        $limrash = $summ*0.1;

         $categoryList = Material::getAllCategories('o');
//         debug($categoryList);
         if(!$categoryList) $categoryList = array();
//         $categoryFurnList = Material::getAllCategories('f');
//         if(!$categoryFurnList) $categoryFurnList = array();


         $materList = Material::getOrderMaterial($oid);
         if(!$materList) $materList = array();

         $prov_categ = Material::getProvCateg();
// //        var_dump($prov_categ); die;
        $page = SITE_PATH.'views/oldideliv.php';
    }
    else{
        $order = Order::getOrderById($oid);
        $contract = $order['contract'];
        $iddis = $order['designer'];
        $idtech = $order['technologist'];
        $infodis = Users::getUserById($iddis);
        $dis = $infodis['name'];
        $infotech = Users::getUserById($idtech);
        $tech = $infotech['name'];

        //суммы
        $summ = $order['sum'];
        $prepayment = $order['prepayment'];
        $limit = $summ*0.3;
        $limrash = $summ*0.1;

        $categoryList = Material::getAllCategories();
        if(!$categoryList) $categoryList = array();
        $categoryFurnList = Material::getAllCategories('f');
        if(!$categoryFurnList) $categoryFurnList = array();


        $materList = Material::getOrderMaterial($oid);
        if(!$materList) $materList = array();

        $prov_categ = Material::getProvCateg();
//        var_dump($prov_categ); die;
        $page = SITE_PATH.'views/orderdeliv.php';
    }
    
    if (isset($_GET['outlay']) && $_GET['outlay']!=0){
        $outlay = $_GET['outlay'];
    }else{
        $outlay = 0;
    }
        $script = '<script type="text/javascript" src="/scripts/delivery.js"></script>';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    
    function actionPivot(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('delivery','Pivot');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
        $page = SITE_PATH.'views/pivot.php';
        // $script = '<script type="text/javascript" src="/scripts/delivery.js"></script>';
        include (SITE_PATH.'views/layout.php');
        
        return true;
    }

    function actionAddCategory(){
        $category = $_POST['cat'];
        $catid = Material::addCategory($category);
        echo $catid;

        return true;
    }
    function actionDelCategory(){
        $catid = $_POST['cat'];
        $res = Material::delCategoryById($catid);
        echo $res;

        return true;
    }
    function actionAddMaterial(){
        $catid = $_POST['cat'];
        $mater = $_POST['mat'];
        $oid = $_POST['oid'];
        $otd = $_POST['otd'];
        $matid = Material::addOrderMaterial($oid,$catid,$mater,$otd);
        echo $matid;

        return true;
    }
    function actionDelMaterial(){
        $matid = $_POST['mat'];
        $res = Material::delMaterialById($matid);
        echo $res;

        return true;
    }
    function actionChangeStatus(){
        $matid = $_POST['matid'];
        $status = $_POST['status'];
        $res = Material::updateStatus($matid, $status);
        echo $res;

        return true;
    }
    function actionAddProvider(){

        $prov = $_POST['provname'];
        $catid = $_POST['catid'];

        $resprov = Material::findProvider($prov);
        if(!empty($resprov)){
            $provid = $resprov['id'];
        }
        else{
            $provid = Material::addProvider($prov);
        }
        $res = Material::addProvCateg($provid,$catid);
        echo $res;
        return true;
    }
    function actionOldi(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('delivery','Oldi');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

//        $script2 = '<script type="text/javascript" src="/scripts/oldideliv.js"></script>';

        $page = SITE_PATH.'views/oldideliv.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionChangeSumm(){
        //idmater+idlogist+summ+oldval
        $idmater = $_POST['idmater'];
        $idlogist = $_POST['idlogist'];
        $summ = $_POST['summ']==''?0:$_POST['summ'];
        $oldsumm = $_POST['oldval'];
        //изменить сумму в материалах
        $res = Material::updateParametr($idmater,'summ',$summ);
        //если есть логистика, изменить там сумму
        if(!empty($idlogist)){
            $res2 = Logistic::updateLogistSumm($oldsumm,$idlogist,-1);
            $res3 = Logistic::updateLogistSumm($summ,$idlogist);
            $res = $res && $res2 && $res3;
        }
        echo $res;
        return true;
    }
    function actionChangeCount(){
        $idmater = $_POST['idmater'];
        $count = $_POST['count']==''?0:$_POST['count'];
        //изменить колво в материалах
        $res = Material::updateParametr($idmater,'count',$count);
        echo $res;
        return true;
    }
    function actionChangeSnabPole(){

        $param = $_POST['param'];//дата, провайдер
        $date = $_POST['date'];
        $summ = $_POST['summ']==''?0:$_POST['summ'];
        $idlogist = $_POST['idlogist'];
        $provid = $_POST['provid'];
        $con = $_POST['con'];
        $idmater = $_POST['idmater'];
        $oid = $_POST['oid'];

        if ($param=='plan_date'){
            $val = $date;
            $opon = $provid;
            $logparam = 'date';
        }else{
            $val = $provid;
            $opon = $date;
            $logparam = 'point';
        }

        //поиск логистики, к которой можно добавить эту поставку
        $logfind = Logistic::getLogistBy2Param('date',$date,'point',$provid);
        if(empty($idlogist)){
            if(empty($val)){
                $res = Material::updateParametr($idmater,$param,null);
            }
            else{
                //создаем или меняем
                if(empty($opon)){
                    $res = Material::updateParametr($idmater,$param,$val);
                }
                else{
//                    var_dump(empty($logfind));
                    if(empty($logfind)){
                        //создаем логистику
                        $logid = Logistic::add($date,'in',$provid,'',$summ,$con);
                        $res1 = Material::updateParametr($idmater,$param,$val);
                        $res2 = Material::updateParametr($idmater,'logist_id',$logid);
                        $res = $res1&&$res2;
                        if($res){
                            $res = "log".$logid;
                        }
                    }
                    else{
                        //добавляем в логистику
                        $res1 = Logistic::updateLogistSumm($summ,$logfind['id']);
                        $pos = strpos($logfind['note'],$con);
                        if($pos===false){
                            $note = $logfind['note'].', '.$con;
                            $res2 = Logistic::updateLogistByParam('note',$note,$logfind['id']);
                        }
                        else{ $res2 = true;}
                        $res3 = Material::updateParametr($idmater,$param,$val);
                        $res4 = Material::updateParametr($idmater,'logist_id',$logfind['id']);
                        $res = $res1 && $res2 && $res3 && $res4;
                        if($res){
                            $res = "log".$logfind['id'];
                        }
                    }
                }
            }
        }
        else{
            //запись в логистике уже есть
            //есть еще материалы по старой логистике?
            $matsforlog = Material::getMaterialsByLogist($idlogist);
            if(count($matsforlog)==1){
                //нет других материалов на старую логистику
                if (empty($val)){
                    //обнулить дату
                    //удалить логистику
                    $res1 = Material::updateParametr($idmater,$param,null);
                    $res2 = Material::updateParametr($idmater,'logist_id',null);
                    Logistic::delLogistById($idlogist);
                    $res = $res1 && $res2;
                    if($res){
                        $res = "log0";
                    }
                }
                else{
                    if(empty($logfind)){
                        //изменить
                        $res1 = Material::updateParametr($idmater,$param,$val);
                        $res2 = Logistic::updateLogistByParam($logparam,$val,$idlogist);
                        $res = $res1 && $res2;
                    }
                    else{
                        //старую логистику удалить, к новой приписать
                        $res1 = Material::updateParametr($idmater,$param,$val);
                        $res2 = Material::updateParametr($idmater,'logist_id',$logfind['id']);
                        $res3 = Logistic::delLogistById($idlogist);
                        $res4 = Logistic::updateLogistSumm($summ,$logfind['id']);
                        $lognote = $logfind['note'];
                        $pos = strpos($logfind['note'],$con);
                        if($pos===false){
                            $note = $logfind['note'].', '.$con;
                            $res5 = Logistic::updateLogistByParam('note',$note,$logfind['id']);
                        }
                        else{ $res5 = true;}
                        $res = $res1 && $res2 && $res3 && $res4 && $res5;
                        if($res){
                            $res = "log".$logfind['id'];
                        }
                    }
                }
            }
            else{
                //есть еще материалы, логистику удалять нельзя

                //изменить сумму старой логистики
                Logistic::updateLogistSumm($summ,$idlogist,-1);


                $i=0;
                foreach ($matsforlog as $mater){
                    if($mater['oid']==$oid){
                        $i++;
                    }
                }
                if ($i==1){
                    //это единственный материал данного заказа, при изменении логистики корректировать примечание
                    $res1 = Material::updateParametr($idmater,$param,$val);
                    //корректировать примечание старой логистики, сумма уже изменена
                    $oldLogist = Logistic::getLogistsByParam('id',$idlogist);
                    $lognote = $oldLogist[0]['note'];
                    $lognote = str_replace($con, '', $lognote);
                    $lognote = str_replace(', , ', ', ', $lognote);
                    $lognote = preg_replace('/^,/', '', $lognote);
                    $lognote = preg_replace('/,$/', '', $lognote);
                    $res2 = Logistic::updateLogistByParam('note',$lognote,$idlogist);
                    //искать логистику на новые параметры
                    if(empty($logfind)){
                        $logid = Logistic::add($date,'in',$provid,'',$summ,$con);
                        $res2 = Material::updateParametr($idmater,'logist_id',$logid);
                        $res = $res1&&$res2;
                        if($res){
                            $res = "log".$logid;
                        }
                    }
                    else{
                        //добавляем в логистику
                        $res1 = Logistic::updateLogistSumm($summ,$logfind['id']);
                        $pos = strpos($logfind['note'],$con);
                        if($pos===false){
                            $note = $logfind['note'].', '.$con;
                            $res2 = Logistic::updateLogistByParam('note',$note,$logfind['id']);
                        }
                        else{ $res2 = true;}
                        $res3 = Material::updateParametr($idmater,$param,$val);
                        $res4 = Material::updateParametr($idmater,'logist_id',$logfind['id']);
                        $res = $res1 && $res2 && $res3 && $res4;
                        if($res){
                            $res = "log".$logfind['id'];
                        }
                    }
                }
                else{
                    //в старой логистике кроме этого материала есть еще с этого заказа. в данной логистике примечание не трогать, а сумма уже изменена
                    $res1 = Material::updateParametr($idmater,$param,$val);
                    //искать логистику на новые параметры
                    if(empty($logfind)){
                        $logid = Logistic::add($date,'in',$provid,'',$summ,$con);
                        $res2 = Material::updateParametr($idmater,'logist_id',$logid);
                        $res = $res1&&$res2;
                        if($res){
                            $res = "log".$logid;
                        }
                    }
                    else{
                        //добавляем в логистику
                        $res1 = Logistic::updateLogistSumm($summ,$logfind['id']);
                        $pos = strpos($logfind['note'],$con);
                        if($pos===false){
                            $note = $logfind['note'].', '.$con;
                            $res2 = Logistic::updateLogistByParam('note',$note,$logfind['id']);
                        }
                        else{ $res2 = true;}
                        $res3 = Material::updateParametr($idmater,$param,$val);
                        $res4 = Material::updateParametr($idmater,'logist_id',$logfind['id']);
                        $res = $res1 && $res2 && $res3 && $res4;
                        if($res){
                            $res = "log".$logfind['id'];
                        }
                    }
                }

            }
        }
        echo $res;
        return true;
    }
    function actionChangeCategoryToMater(){
        $catid = $_POST['catid'];
        $mid = $_POST['mid'];
        
        $res = Material::updateParametr($mid,'catid',$catid);

        return true;
    }

    function actionNewOutlay(){
        $point = $_POST['point'];
        
        $res = Outlay::add($point);
        
        echo $res;
        return true;
    }
    
    function actionSetToOutlay(){
        $oid = $_POST['oid'];
        $olid = $_POST['olid'];
        
        $res = Material::updateOutlayToMaterial($oid,$olid);
        
        echo !!$res;
        return true;
    }
    
    function actionGetOutlay(){
        $olid = $_POST['olid'];
        
        $res = Material::getMaterialsByOutlay($olid);
        
        echo json_encode($res);
        return true;
    }
    
    function actionUpdateToOutlay(){
        $mid = $_POST['mid'];
        $olid = isset($_POST['olid'])?$_POST['olid']:0;
        // $mid = 20837;
        $res = Material::updateParametr($mid,'outlay_id',$olid);
        
        echo $res;
        return true;
    }

}