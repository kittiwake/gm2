<?php

class Controller_plan {

    public $shablon = array(
        array(
            0=>'пила',
            1=>'чпу',
            3=>'кромка',
            13=>'криволинейка',
            4=>'присадка',
            2=>'гнутье',
            11=>'фасады',
        ),
        array(
            6=>'пвх',
            5=>'эмаль',
            7=>'фотопечать',
            8=>'пескоструй',
            9=>'витраж',
            10=>'оракал',
            12=>'упаковка'
        ));
    public $shablon1 = array(
        array(
            0=>'пила',
            3=>'кромка',
            4=>'присадка',
            7=>'криволинейка'
        ),
        array(
            1=>'чпу',
            2=>'гнутье',
            5=>'фасады',
            6=>'упаковка'
        ));
    public $arr_stan_date = array('raspil_date', 'cpu_date', 'gnutje_date', 'kromka_date', 'pris_date', 'emal_date', 'pvh_date', 'photo_date', 'pesok_date', 'vitrag_date', 'oracal_date', 'fas_date', 'upak_date','krivolin_date');
    public $arr_stan = array(
        'raspil',
        'cpu',
        'gnutje',
        'kromka',
        'pris_end',
        'emal',
        'pvh',
        'photo',
        'pesok',
        'vitrag',
        'oracal',
        'fas',
        'upak_end',
        'krivolin');
    public $arr_stan_date1 = array('raspil_date', 'cpu_date', 'gnutje_date', 'kromka_date', 'pris_date', 'fas_date', 'upak_date','krivolin_date');
    public $arr_stan1 = array(
        'raspil',
        'cpu',
        'gnutje',
        'kromka',
        'pris_end',
        'fas',
        'upak_end',
        'krivolin'
    );
    
            
            
    public $arr_olstan_date = array(
        'raspil_date',
        'frez_date',
        'obk_date',
        'pvh_date',
        'grunt_date',
        'emal_date',
        'polir_date',
        'upak_date',
        'klej_date',
        'shlif1_date',
        'shlif2_date',
        'shlif0_date',
        'isolator_date'
    );
    public $arr_olstan = array(
        'raspil',
        'frez',
        'obk',
        'pvh',
        'grunt',
        'emal',
        'polir',
        'upak',
        'klej',
        'shlif1',
        'shlif2',
        'shlif0',
        'isolator'
    );
    public $olshablon = array(
        array(
            0=>'пила',
            1=>'фрезер',
            2=>'обкатка',
            8=>'шлифовка/клей',
            3=>'пвх',
            6=>'полировка',
        ),
        array(
            11=>'шлифовка1',
            12=>'изолятор',
            9=>'шлифовка2',
            4=>'грунт',
            10=>'шлифовка3',
            5=>'эмаль',
            )
        );

    function actionTech(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('plan','Tech');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
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
        foreach ($no_appoint as $key=>$order){
            if(preg_match('/^[AА](\d{3})(\w)?$/u', $order['contract'])==1){
                unset($no_appoint[$key]);
            };
        }
        //список дизайнеров
        $userList5 = User_post::getUsersByPost(5);
        $disList = array();
        foreach($userList5 as $disid){
            $datadis = Users::getUserById($disid['uid']);
            $disList[$datadis['id']] = Datas::nameAbr($datadis['name']);
        }
// var_dump($_GET);die;

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

    function actionCeh1($date=null){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('plan','Ceh1');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        if($date==null) $date = strtotime('today');
        $userdate = date('d.m.Y', $date);
        $week = array('ВС','ПН','ВТ','СР','ЧТ','ПТ','СБ');
        $arr_stan_date = $this->arr_stan_date1;
        $arr_stan = $this->arr_stan1;
        $shablon = $this->shablon1;
        $today = strtotime('today');

        $orders = Order::getOrdersFromToday();//готовый массив [дата][0]=>{[oid]=>oid, [con]=>контракт}

        $stan_gotov = array();
        foreach($orders as $i=>$list){
            foreach($list as $k=>$order){
                $stan_gotov = OrderStan::getStanString($order['oid'],$arr_stan);
                $orders[$i][$k]['stan']=$stan_gotov['stan'];
                $partsdb = OrderPart::getByOid($order['oid']);
                $parts = array();
                foreach ($partsdb as $j=>$part){
                    $str = '';
                    foreach ($arr_stan as $pole){
                        $str .= $part[$pole];
                    }
                    $parts['pid'] = $part['id'];
                    $parts['suf'] = $part['suf'];
                    $parts['note'] = $part['note'];
                    $parts['stan'] = $str;
                    $orders[$i][$k]['parts'][]=$parts;
                }
            }
        }
//        var_dump($orders);die;

        if($date==$today){
            //берем все невыполненные заказы
            foreach($arr_stan as $i=>$pole){
                $list_graf = Sequence::getSequenceTillToday($pole,$arr_stan_date[$i]);
                $listpart_graf = Sequence::getPartSequenceTillToday($pole,$arr_stan_date[$i]);
                $lost = array();
                $seq = array();
                $noseq = array();
                foreach ($list_graf as $item){
                    if($item['sequence']==0){
                        $noseq[] = [
                            'oid' => $item['id'],
                            'partid' => 0,
                            'contract' => $item['contract'],
                            'suff' => null,
                            'date' => $item[$arr_stan_date[$i]],
                            'sequence' => 0,
                            'mater' => $item['mater']
                        ];
                    }else{
                        if(strtotime($item[$arr_stan_date[$i]]) < $today){
                            $lost[$item['sequence']] = [
                                'oid' => $item['id'],
                                'partid' => 0,
                                'contract' => $item['contract'],
                                'suff' => null,
                                'date' => $item[$arr_stan_date[$i]],
                                'sequence' => $item['sequence'],
                                'mater' => $item['mater']
                            ];
                        }else{
                            $seq[$item['sequence']] = [
                                'oid' => $item['id'],
                                'partid' => 0,
                                'contract' => $item['contract'],
                                'suff' => null,
                                'date' => $item[$arr_stan_date[$i]],
                                'sequence' => $item['sequence'],
                                'mater' => $item['mater']
                            ];
                        }
                    }
                }
                foreach ($listpart_graf as $item){
                    if(!isset($item['sequence'])){
                        $noseq[] = [
                            'oid' => $item['id'],
                            'partid' => $item['id'],
                            'contract' => $item['contract'],
                            'suff' => null,
                            'date' => $item[$arr_stan_date[$i]],
                            'sequence' => 0,
                            'mater' => $item['note']
                        ];
                    }else{
                        if(strtotime($item[$arr_stan_date[$i]]) < $today){
                            $lost[$item['sequence']] = [
                                'oid' => $item['id'],
                                'partid' => 0,
                                'contract' => $item['contract'],
                                'suff' => null,
                                'date' => $item[$arr_stan_date[$i]],
                                'sequence' => $item['sequence'],
                                'mater' => $item['note']
                            ];
                        }else{
                            $seq[$item['sequence']] = [
                                'oid' => $item['id'],
                                'partid' => 0,
                                'contract' => $item['contract'],
                                'suff' => null,
                                'date' => $item[$arr_stan_date[$i]],
                                'sequence' => $item['sequence'],
                                'mater' => $item['note']
                            ];
                        }
                    }
                }
                
            }
        }else{
            foreach($arr_stan as $i=>$pole){
                $list_graf[$pole] = Sequence::getSequenceForDate($pole,$arr_stan_date[$i],date('Y-m-d',$date));
                $listpart_graf[$pole] = Sequence::getPartSequenceForDate($pole,$arr_stan_date[$i],date('Y-m-d',$date));
                $seq = array();
                $noseq = array();
                foreach ($list_graf as $item){
                    if($item['sequence']==0){
                        $noseq[] = [
                            'oid' => $item['id'],
                            'partid' => 0,
                            'contract' => $item['contract'],
                            'suff' => null,
                            'date' => $item[$arr_stan_date[$i]],
                            'sequence' => 0,
                            'mater' => $item['mater']
                        ];
                    }else{
                        $seq[$item['sequence']] = [
                            'oid' => $item['id'],
                            'partid' => 0,
                            'contract' => $item['contract'],
                            'suff' => null,
                            'date' => $item[$arr_stan_date[$i]],
                            'sequence' => $item['sequence'],
                            'mater' => $item['mater']
                        ];
                    }
                }
                foreach ($listpart_graf as $item){
                    if(!isset($item['sequence'])){
                        $noseq[] = [
                            'oid' => $item['id'],
                            'partid' => $item['id'],
                            'contract' => $item['contract'],
                            'suff' => null,
                            'date' => $item[$arr_stan_date[$i]],
                            'sequence' => 0,
                            'mater' => $item['note']
                        ];
                    }else{
                        $seq[$item['sequence']] = [
                            'oid' => $item['id'],
                            'partid' => 0,
                            'contract' => $item['contract'],
                            'suff' => null,
                            'date' => $item[$arr_stan_date[$i]],
                            'sequence' => $item['sequence'],
                            'mater' => $item['note']
                        ];
                    }
                }
            }
        }

        die;

        $page = SITE_PATH.'views/planceh.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionCeh($date=null){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('plan','Ceh');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
        if($date==null) $date = strtotime('today');
        $userdate = date('d.m.Y', $date);
        $week = array('ВС','ПН','ВТ','СР','ЧТ','ПТ','СБ');
        $arr_stan_date = $this->arr_stan_date1;
        $arr_stan = $this->arr_stan1;
        $shablon = $this->shablon1;
        $today = strtotime('today');
        $orders = Order::getOrdersFromToday();//готовый массив [дата][0]=>{[oid]=>oid, [con]=>контракт}
 //       debug($orders);
        $stan_gotov = array();
        foreach($orders as $i=>$list){
            foreach($list as $k=>$order){
                $stan_gotov = OrderStan::getStanString($order['oid'],$arr_stan);
                $orders[$i][$k]['stan']=$stan_gotov['stan'];
            }
        }
 //       debug($orders);
        if($date==$today){
            //берем все невыполненные заказы
            foreach($arr_stan as $i=>$pole){
                $list_graf[$pole] = Sequence::getSequenceTillToday($pole,$arr_stan_date[$i]);
            }
        }else{
            foreach($arr_stan as $i=>$pole){
                $list_graf[$pole] = Sequence::getSequenceForDate($pole,$arr_stan_date[$i],date('Y-m-d',$date));
//debug($list_graf[$pole]); 
            }
        }
//debug($list_graf); 
//        var_dump($orders); die;

        $page = SITE_PATH.'views/planceh1.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionMdf($date=null){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('plan','Mdf');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        if($date==null) $date = strtotime('today');
        $userdate = date('d.m.Y', $date);
        $week = array('ВС','ПН','ВТ','СР','ЧТ','ПТ','СБ');
        
//        $arr_stan_date = $this->arr_olstan_date;
//        $arr_stan = $this->arr_olstan;
//        $shablon = $this->olshablon;
        
        $etaps_list = Oldi::getEtaps(3);
        //debug($etaps);
        $today = strtotime('today');
        foreach ($etaps_list as $num_etap=>$list){
            $shablon[$num_etap] = $list['etap'];
            $arr_stan_date[$num_etap] = $list['etap_date'];
            $arr_stan[$num_etap] = $list['etap_stan'];
        }
        $orders = Oldi::getOrdersFromToday();//готовый массив [дата][0]=>{[oid]=>oid, [con]=>контракт}
        //debug($shablon);
        $stan_gotov = array();
        $str = '';
        foreach($arr_stan as $pole){
            $str = $str . '`' . $pole . '`,';
        }
        $str = substr($str, 0, -1);
        // debug($arr_stan);
        foreach($orders as $i=>$list){
            foreach($list as $k=>$order){
                $stan_gotov = Oldi::getStanString($order['oid'],$arr_stan);
                
        // debug($stan_gotov);
                $orders[$i][$k]['stan']=$stan_gotov['stan'];
            }
        }
        // debug($orders);
        if($date==$today){
            //берем все невыполненные заказы
            foreach($arr_stan as $i=>$pole){
                $list_graf[$pole] = Sequence::getOldiSequenceTillToday($pole,$arr_stan_date[$i]);
                
            }
        }else{
            foreach($arr_stan as $i=>$pole){
                $list_graf[$pole] = Sequence::getOldiSequenceForDate($pole,$arr_stan_date[$i],date('Y-m-d',$date));
            }
        }

        $page = SITE_PATH.'views/plancehmdf.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    function actionPart(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('plan','Part');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $week = array('ВС','ПН','ВТ','СР','ЧТ','ПТ','СБ');
        $arr_stan = $this->arr_stan1;
        $arr_stan_date = $this->arr_stan_date1;
        $orders = Order::getOrdersFromToday();//готовый массив [дата][0]=>{[oid]=>oid, [con]=>контракт}

        $part = array();
        foreach ($orders as $date => $dayorder){
            foreach ($dayorder as $k => $order){
                $oid = $order['oid'];
                $con = $order['con'];
                $parts = OrderPart::getByOid($oid);
                if(!empty($parts))
                $part[$con] = $parts;
                $orders[$date][$k]['part'] = $parts;
            }
        }

        $bgcol = ['lavender','#666666','#33bb00'];

        $page = SITE_PATH.'views/order_part.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionChangeStanPart(){
        $pid = $_POST['partid'];
        $pole = $_POST['pole'];
        $val = $_POST['val'];

        $res = OrderPart::updateParam($pid,$pole,$val);
        echo $res;
        return true;
    }

    function actionChangeDatePart(){

//        data: "id=" + partid + "&pole=" + pole + "&date=" + datec + "&perenos=0",
        $pid = $_POST['id'];
        $pole = $this->arr_stan_date1[$_POST['pole']];
        $val = $_POST['date'];
        $datedb = preg_replace('/(\d{1,2})\.(\d{1,2})\.(\d{4})/','\3-\2-\1',$val);
        $perenos = $_POST['perenos'];
        //проверка наличия запланированной даты

        $res1 = OrderPart::getById($pid);
        if(!isset($res1[$pole]) || strtotime($res1[$pole])>strtotime($datedb) || $perenos==1){
            $res = OrderPart::updateParam($pid,$pole,$val);
        }else{
            $res = $res1[$pole];
            $res = preg_replace('/(\d{4})\-(\d{2})\-(\d{2})/','\3.\2.\1',$res);
        }

        echo $res;
//        echo $pole;
        return true;
    }

    function actionChangePart(){
        $_POST['oid']=9618;
        $_POST['arr']='[{"pre":"гард","mater":"3"},{"pre":"прих","mater":"4"}]';
        $oid = $_POST['oid'];
        $arr = json_decode($_POST['arr']);
        $upd = array();

        foreach ($arr as $k => $item){
            if (isset($item->pid)){
                $upd[]=$item;
                unset($arr[$k]);
            }
        }

debug($arr);
        $res1 = true;
        $res2 = true;
        // if(!empty($upd)){
        //     $res2 = OrderPart::update($upd);
        // }
        // if(!empty($arr)){
        //     $res1 = OrderPart::add($oid, $arr);
        // }

        echo($res1 && $res2);

//        var_dump($upd);
//        var_dump($arr);
        return true;
    }

    function actionDeletePart(){
        $pid = $_POST['pid'];
        $res = OrderPart::deleteById($pid);
        echo $res;
        return true;
    }

    function actionChangeDateStan(){
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $poledb = $this->arr_stan_date1[$pole];
        $date = $_POST['date'];
        $datedb = preg_replace('/(\d{1,2})\.(\d{1,2})\.(\d{4})/','\3-\2-\1',$date);
        $perenos = $_POST['perenos'];

        $resget = OrderStan::getOrdersByPole('oid', $oid);
        if($resget[$oid][$poledb] == '0000-00-00' || strtotime($resget[$oid][$poledb])>strtotime($datedb) || $perenos==1){
            $res = OrderStan::updateStanByParam($poledb,$datedb,$oid);
        }else{
            $res = $resget[$oid][$poledb];
            $res = preg_replace('/(\d{4})\-(\d{2})\-(\d{2})/','\3.\2.\1',$res);
        }
        echo $res;

        return true;
    }
    function actionChangeDateStanTest(){
        
        $gmol = $_POST['gmol'];
        
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
//        $msec = $_POST['msec'];
        $date = $_POST['date'];
        $datedb = preg_replace('/(\d{1,2})\.(\d{1,2})\.(\d{4})/','\3-\2-\1',$date);
        $perenos = $_POST['perenos'];
        
        if($gmol == 'ceh'){
    
            $poledb = $this->arr_stan_date1[$pole];
            
            $resget = OrderStan::getOrdersByPole('oid', $oid);
            if($resget[$oid][$poledb] == '0000-00-00' || strtotime($resget[$oid][$poledb])>strtotime($datedb) || $perenos==1){
                $res = OrderStan::updateStanByParam($poledb,$datedb,$oid);
    //            $res = 1;
            }else{
                $res = $resget[$oid][$poledb];
                $res = preg_replace('/(\d{4})\-(\d{2})\-(\d{2})/','\3.\2.\1',$res);
            }
            echo $res;
        }
        if($gmol == 'mdf'){
  //          echo 'это олди';
            $poledb = $this->arr_olstan_date[array_search($pole,$this->arr_olstan)];
            $resget = Oldi::getStanByOid('oid', $oid);
            if($resget[$poledb] == null || strtotime($resget[$poledb])>strtotime($datedb) || $perenos==1){
                $res = Oldi::updateStanByParam($poledb,$datedb,$oid);
            }else{
                $res = preg_replace('/(\d{4})\-(\d{2})\-(\d{2})/','\3.\2.\1',$resget[$poledb]);
            }
            echo $res;
        }

        return true;
    }

    function actionGetListByDate(){
        $stanid = $_POST['stanid'];
        $dateStan = $_POST['dateStan'];
        $orderList =
        $sql = "SELECT * FROM `order_stan`,`progression` WHERE `order_stan`.`oid`=`progression`.`oid` AND `order_stan`.`raspil_date` = \'2016-06-22\' AND `progression`.`pole` = \'0\' order by `sequence`";
        echo $stanid;

        return true;
    }

    function actionChangeSequence(){
        if (isset($_POST['data'])) {
            $php_json = json_decode($_POST['data'], TRUE);
            $arr_stan = $this->arr_stan1;
            foreach($php_json as $poradok=>$domid){
                $parts = explode('-',$domid);
                $etap = $parts[0];
                $oid = $parts[1];
                $res=Progression::setProgression($oid,$etap,$poradok);

            }
            echo $res;
        }
        return true;

    }
    function actionChangePosition(){
        $str = $_POST['list'];
        $gmol = $_POST['gmol']=='ceh'?'g':'o';
        
//        $str = "isolator-10151-1-0;isolator-10159-0-1;";
//        $gmol = 'o';
        
        $parts = explode(';',$str);
        $num = count($parts)-1;
        if($gmol == 'g'){
            $etaps = $this->arr_stan1;
        }
//        if($gmol == 'o'){
//            $etaps = $this->arr_olstan;
//        }
//        debug ($parts);
        for($i=0; $i<$num; $i++){
            $partsone = explode('-',$parts[$i]);
            debug($partsone);
            $etap = $gmol == 'g'?$etaps[$partsone[0]]:$partsone[0];
            $oid = $partsone[1];
            $poradok = $partsone[3];
            $res=Sequence::setSequence($oid,$etap,$poradok,$gmol);
            debug($res);
        }
        return true;
    }

//    function actionAlexandria(){
//        $ri = $_SESSION['ri'];
//        $log = $_SESSION['login'];
//
//        $today = strtotime('today');
//        $orders = Order::getOrdersFromToday();//готовый массив [дата][0]=>{[oid]=>oid, [con]=>контракт}
//        $stan_gotov = array();
//        foreach($orders as $list){
//            foreach($list as $order){
//                $stan_gotov[$order['oid']] = OrderStan::getStanString($order['oid']);
//            }
//        }
//
//        $graf = array();
//        $graf_y = array();
//        $arr_stan_date = $this->arr_stan_date;
//        $arr_stan = $this->arr_stan;
//        foreach($arr_stan_date as $stan_date){
//            $graf[$stan_date]=array();
//            $graf_y[$stan_date]=array();
//        }
//        $shablon = $this->shablon;
//        foreach($arr_stan_date as $key=>$stan){
//            $orders_gr = OrderStan::getOrdersByPole($stan, date('Y-m-d', $date));
//            $orders_yesterday = OrderStan::getNeVipoln($stan,$arr_stan[$key]);
//            foreach($orders_gr as $oid=>$arr){
//                $aboutord = Order::getOrderById($oid);
//
//                if(!empty($aboutord)){
//                    $graf[$stan][$oid] = $arr + $aboutord;
//                }
//            }
//            if(!$orders_gr){
//                $graf[$stan] = array();
//            }
//            foreach($orders_yesterday as $oid=>$arr){
//                $aboutord = Order::getOrderById($oid);
//                if(!empty($aboutord)){
//                    $graf_y[$stan][$oid] = $arr + $aboutord;
//                }
//            }
//            if(!$orders_yesterday){
//                $graf_y[$stan] = array();
//            }
//        }
//        $page = SITE_PATH.'views/planalex.php';
//        include (SITE_PATH.'views/layout.php');
//
//        return true;
//    }

    function actionStan(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('plan','Stan');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $script2 = '<script type="text/javascript" src="/scripts/planstan.js"></script>';

        $page = SITE_PATH.'views/planstan.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionStan1(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,3);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $script2 = '<script type="text/javascript" src="/scripts/planstan1.js"></script>';

        $page = SITE_PATH.'views/planstan.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionGetOrders(){
        $end = Datas::dateToDb($_POST['end']);
        $begin = Datas::dateToDb($_POST['begin']);
        $oderby = $_POST['oderby'];

//        $end = '2018-01-18';
//        $oderby = 'plan'; 9250943539 реутов салон

        $res = OrderStan::getOrdersFromToday($begin,$end,$oderby);
        foreach($res as $key=>$order){
            if($order['technologist']==0){
                $res[$key]['tech']='';
            }
            else{
                $user = Users::getUserById($order['technologist']);
                $res[$key]['tech']=$user['name'];
            }
            if($order['designer']==0){
                $res[$key]['dis']='';
            }
            else{
                $user = Users::getUserById($order['designer']);
                $res[$key]['dis']=$user['name'];
            }
        }

//        $db = Db::getConection();
//
//        $orderList = array();

//        $str = '
//SELECT `orders`.`id`, `orders`.`contract`, `orders`.`term`,`plan`,`tech_end`,`mater`,`raspil`, `cpu`, `gnutje`, `kromka`, `krivolin`, `pris_end`, `emal`, `pvh`, `photo`, `pesok`, `oracal`, `fas`, `vitrag`, `upak_end`
//FROM `orders`,`order_stan`
//WHERE `orders`.`id`=`order_stan`.`oid`
//AND `order_stan`.`plan` BETWEEN :datebegin AND :datend
//ORDER BY '.$oderby;

//        echo $str;

//        $res = $db->prepare($str);
//
//
//        $res->execute(array(
//            ':datend'=>$end,
//            ':datebegin'=>$begin
//        ));
//        $res->setFetchMode(PDO::FETCH_ASSOC);
//
//        while ($row = $res->fetch()){
//            $orderList[$row['id']] = $row;
//            //         $orderList[$i]['plan'] = $row['plan'];
//        }
//

        echo json_encode($res);
        return true;
    }

    function actionChangeStan(){
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $val = $_POST['val'];
        if(preg_match('/^\d+$/', $pole)){
            $pole = $this->arr_stan1[$pole];
        }

        $res = OrderStan::updateStanByParam($pole,$val,$oid);

        echo $res;
        return true;
    }

    function actionAddNoteBoss(){
        //'oid='+oid+'&pole='+pole+'&note='+txt
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $note = $_POST['note'];
//        $oid = 4444;
//        $pole = 'mater';
//        $note = 'прямой ввод';

        //искать существующую запись
        $find = Bossnotes::getNote($oid,$pole);
        //если нашли, заменить на новую
        if(!!$find){
            $id = $find['id'];
            $res = Bossnotes::updateNote($id,$note);
        }
        //если нет - добавить
        else{
            $res = Bossnotes::addNote($oid,$pole,$note);
        }

        echo $res;
        return true;
    }

    function actionDelNoteBoss(){
        //'oid='+oid+'&pole='+pole+'&note='+txt
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];

        $res = Bossnotes::delOrderNote($oid,$pole);

        echo $res;
        return true;
    }

    function actionGetOrderNotes(){
        $oid = $_POST['oid'];

        $res = Bossnotes::getOrderNotes($oid);

        echo count($res)>0?json_encode($res):false;
        return true;
    }

    function actionChangeOldiStan(){
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $val = $_POST['val'];
//        if(preg_match('/^\d+$/', $pole)){
//            $pole = $this->arr_olstan[$pole];
//        }

        $res = Oldi::updateStanByParam($pole,$val,$oid);

        echo $res;
        return true;
    }

}

