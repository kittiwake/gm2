<?php

class Controller_designer {
    private $filelist = array();

    function actionPlan() {


        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,2,55,58,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

//        if($ri == 20){
//            header('Content-Type: text/html; charset= CP866');
//        }

        if(isset($_POST['submitok'])){
            $oid = $_POST['oid'];
            if(isset($_POST['newdate'])){
                $newdate = Datas::dateToDb($_POST['newdate']);//'yyyy-mm-dd'
                Plan_dis::updateSamplesByParam('date_dis',$newdate,$oid);
            }
        }

//список дизайнеров
        $userList = User_post::getUsersByPost(5);

        $disList = array();
        $dList = array();
        $listDisNotValid = array();
        foreach ($userList as $uid){
            $datasb = Users::getUserById($uid['uid']);
            $abr = Datas::nameAbr($datasb['name']);
            if($datasb['validation'] == 1){
//                $abr = Datas::nameAbr($datasb['name']);
                $disList[$datasb['id']] = $abr;
                $dList[$datasb['id']] = $datasb;
            }else{
                $listDisNotValid[$datasb['id']] = $abr;
            }
        }
        asort($disList);

        $users = Users::getUsersByParam('user_right',2);
        foreach($users as $user){
            if($user['validation'] == 1){
                $dList[$user['id']] = $user;
            }
        }
        //тетрадь замеров
        $samples = array();
        $holidays = array();
        $sample_arr = Plan_dis::getCurrent();
        foreach($sample_arr as $key=>$sample){
            if($sample['contract']=='Выходной' && strtotime($sample['date_dis'])<strtotime('today')){
                Plan_dis::updateSamplesByParam('stan','holiday',$sample['id']);
            }else{
                if($sample['dis']!='0'){
                    if(array_key_exists($sample['dis'],$disList)) {
                        $sample['dis_name'] = $disList[$sample['dis']];
                    }
                    else{
                        $sample['dis_name'] = $listDisNotValid[$sample['dis']];
                    }
                }else{
                    $sample['dis_name'] = '';
                }
                //цвет ячейки
                $con_color = '';
                $str_color = '';
                if($sample['stan'] == 'new') $con_color = 'Lightpink';
                if($sample['stan'] == 'zakluchen') $con_color = 'Palegreen';
                if($sample['render'] == 'money') {
                    $str_color = 'Palegreen';
                }
                if($sample['contract']=='Выходной') {
                    $str_color = 'Palegoldenrod';
                    $con_color = 'Palegoldenrod';
                }
                $sample['con_color'] = $con_color;
                $sample['str_color'] = $str_color;
                $samples[$sample['date_dis']][] = $sample;
                if($sample['contract']=='Выходной'){
                    $holidays[]=array(
                        'dis_name'=>$sample['dis_name'],
                        'date_dis'=>$sample['date_dis'],
                        'id'=>$sample['id']
                    );
                }
            }
        }
        ksort($samples);
//var_dump($samples);die;
        $week = array('воскресенье','понедельник','вторник','среда','четверг','пятница','суббота');

        $script2 = '<script type="text/javascript" src="/scripts/designer.js"></script>';
        $page = SITE_PATH.'views/sample.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionIndex(){


        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $user = $_SESSION['uid'];
//        if($ri == 1)
//        $user = 43;

        $allowed = array(1,5,55);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $samplelist = Plan_dis::getSamplesByDis($user);
        $sample_plan = array();
        $sample_new = array();
        $sample_zakl = array();
        $sample_arhiv = array();

        foreach($samplelist as $sample){
            if($sample['stan'] == 'tekuch'){
                $sample_plan[] = $sample;
            }elseif($sample['stan'] == 'new'){
                $sample_new[] = $sample;
            }elseif($sample['stan'] == 'arhiv'){
                $sample_arhiv[] = $sample;
            }elseif($sample['stan'] == 'zakluchen'){
                //проверка, что сдано
                if($sample['render'] != 'all')
                    $sample_zakl[] = $sample;
            }
        }

        $order_in_fabr = OrderStan::getNotEndForDis($user);
        $claims = array();
        foreach($order_in_fabr as $key=>$order){
            if($order['otgruz_end']==2){
                $color = '#ffff00';
                $claims[$order['oid']] = Order::getClaimsByContract($order['contract']);
            }
            elseif($order['upak_end']==2)$color = '#00b050';
            elseif($order['tech_end']==2)$color = '#00b0f0';
            else $color = '';
            $order_in_fabr[$key]['bgcol'] = $color;
        }

        $order_last_month = OrderStan::getDisEnd($user);

        $script = '<script type="text/javascript" src="/scripts/designer.js"></script>';
        $page = SITE_PATH.'views/designer.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionChange(){
        $oid = $_POST['oid'];
        $uid = $_POST['uid'];
        $res = Plan_dis::updateSamplesByParam('dis',$uid,$oid);

        return true;
    }

    function actionChangePole(){
        $oid = $_POST['oid'];
        $pole = $_POST['pole'];
        $val = $_POST['val'];
        if(isset($_POST['note'])){
            $note = $_POST['note'];
            $res2 = $this->actionAddNote();
        }
        if(isset($_POST['sum'])&&isset($_POST['pred'])){
            $sum = $_POST['sum'];
            $pred = $_POST['pred'];
            $beznal = $_POST['nal']=='true' ? 0 : 1;
            $res2 = Plan_dis::updateSamplesByParam('sum',$sum,$oid);
            $res3 = Plan_dis::updateSamplesByParam('prepayment',$pred,$oid);
            $res4 = Plan_dis::updateSamplesByParam('beznal',$beznal,$oid);
        }
        $res = Plan_dis::updateSamplesByParam($pole,$val,$oid);
        echo $res;

        return true;
    }
//    function actionChangeRender(){
//        //'oid='+oid+'&sum='+sum+'&prep='+prep+'&money='+money+'&paper='+paper
//        $oid = $_POST['oid'];
//        $res1 = true;
//        $res2 = true;
//        if(isset ($_POST['sum']) && isset ($_POST['prep'])) {
//            $sum = $_POST['sum'];
//            $prep = $_POST['prep'];
//            $beznal = $_POST['beznal'];
//            $res1 = Plan_dis::updateSamplesByParam('sum',$sum,$oid);
//            $res2 = Plan_dis::updateSamplesByParam('prepayment',$prep,$oid);
//            if($beznal == 1){
//                $res4 = Plan_dis::updateSamplesByParam('beznal',1,$oid);
//            }
//        }
//
//        $res3 = true;
//        if(isset ($_POST['ren'])){
//            $render = $_POST['ren'];
//            $res3 = Plan_dis::updateSamplesByParam('render',$render,$oid);
//            if($render == 'all' && $res3){
//                Plan_dis::updateSamplesByParam('stan','zakluchen',$oid);
//            }
//        }
//        $res = $res1 || $res2 || $res3;
//
//        echo $res;
//
//        return true;
//    }

    function actionAddNote(){
        $oid = $_POST['oid'];
        $note = $_POST['note'];
        //достать из базы примечание
        $res = Plan_dis::getSamplesByParam('id', $oid);
        $notes = $res[0]['note'];
        $date = date('d.m');
        $notes .= '<p><b>'.$date.'</b> '.$note.'</p>';
        //дополнить его и перезаписать
        $res2 = Plan_dis::updateSamplesByParam('note',$notes,$oid);
        if($res) echo $date;

        return true;
    }
    function actionDeleteSample(){

        $oid = $_POST['oid'];
        $res = Plan_dis::updateSamplesByParam('stan','delete',$oid);

        echo $res;
        return true;
    }
    function actionChangeAll(){
        $oid = $_POST['oid'];
        $contr = $_POST['contr'];
        $addr = $_POST['addr'];
        $sum = $_POST['summ'];

        $res1 = Plan_dis::updateSamplesByParam('empty', $sum, $oid);
        $res2 = Plan_dis::updateSamplesByParam('contract', $contr, $oid);
        $res3 = Plan_dis::updateSamplesByParam('address', $addr, $oid);
        $res = $res1 && $res2 && $res3;

        echo $res;
        return true;
    }

    function actionArhiv(){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,2,55,58);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

//        if($ri == 20){
//            header('Content-Type: text/html; charset= CP866');
//        }
//список дизайнеров
        $userList = User_post::getUsersByPost(5);
        $disList = array();
        foreach ($userList as $uid){
            $datasb = Users::getUserById($uid['uid']);
//            if($datasb['operative'] == 1){
                $abr = Datas::nameAbr($datasb['name']);
                $disList[$datasb['id']] = $abr;
//            }
        }
        asort($disList);

        //таблица архивов
        $samples = array();
        $sample_arr = Plan_dis::getSamplesByParam('stan','arhiv');
        foreach($sample_arr as $key=>$sample){
            if($sample['dis']!='0'){
                $sample['dis_name'] = $disList[$sample['dis']];
            }else{
                $sample['dis_name'] = '';
            }
            $samples[$sample['date_dis']][] = $sample;
        }
        ksort($samples);
//var_dump($samples);die;

        $script2 = '<script type="text/javascript" src="/scripts/designer.js"></script>';
        $page = SITE_PATH.'views/sample_arhiv.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }
//    function actionShowPhotos(){
//
//        //путь к файлам
//
//        $year = $arrdte[0];
//        $path = '../baza/ЗАКАЗЫ/'.$year.'/';
//
//        $contract = $order['contract'];
//        $pieces = explode("-", $contract);
//
//        if (($pieces[0]+0) != 0 ){
//            $path .= $pieces[0].'-'.$pieces[1][0].'00-'.$pieces[1][0].'99/'.$contract;
//        }
//        elseif(mb_substr($contract,0,1,'utf-8') == 'Р'){
//            $path .= 'Салон/'.$contract;
//        }
//        elseif(mb_substr($contract,0,1,'utf-8') == 'Г'){
//
//            $path .= 'Гранд/ГР-'.$pieces[1];
//
//        }
//        else{
//            $path .= 'Дилеры/'.$contract;
//        }
//
//        if(is_dir($path)){
//            $skip = array();
//            $files = $this->readAllFiles($path);
//        }
//        $page = SITE_PATH.'views/sample.php';
//        include (SITE_PATH.'views/layout.php');
//        return true;
//    }

    function actionHoliday(){
        $answer = false;

        $dis = $_POST['dis'];
        $date = $_POST['date'];
        $dbdate = date('Y-m-d', strtotime($date));
        //проверить наличие замеров на эту дату
        $samples = Plan_dis::getSamplesByParam('date_dis',$dbdate);
//        $answer = $samples[0]['dis'];
        if(count($samples)!=0){
            foreach($samples as $sample){
                if($sample['dis']==$dis){
                    $answer = 'На эту дату у дизайнера назначен выезд';
                }
            }
        }
        if(!$answer){
            $res = Plan_dis::addNew('Выходной','Выходной',$dbdate,$dis,'',0,$_SESSION['login']);
            if($res){
                $answer = $res;
            }else{
                $answer = 'Ошибка в сисеме';
            }
        }

        echo $answer;
        return true;
    }
    function actionCancelHoliday(){
        $id = $_POST['id'];
        $res = Plan_dis::deleteSample($id);
        echo $res;
        return true;
    }

    function actionSample($oid){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,2,5,55,58,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $res = Plan_dis::getSamplesByParam('id',$oid);
        $sample = $res[0];

//список дизайнеров
        $userList = User_post::getUsersByPost(5);
        $disList = array();
        foreach ($userList as $uid){
            $datasb = Users::getUserById($uid['uid']);
                $abr = Datas::nameAbr($datasb['name']);
                $disList[$datasb['id']] = $abr;
        }
        asort($disList);

//поиск менеджера
        $res = Users::getUsersByParam('user_login', $sample['name_men']);
        if(count($res)!=0){
            $sample['name_men']=$res[0]['name'];
        }
        $page = SITE_PATH.'views/sampleone.php';
        include (SITE_PATH.'views/layout.php');

        return true;

    }

    function actionClosed($oid){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,5);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
//        die("Нет доступа к фото!");
        $order = Order::getOrderById($oid);
        $order_stan = OrderStan::getOrdersByPole('oid', $oid);

        //путь к файлам
        $dte = $order_stan[$oid]['plan'];
        $arrdte = explode('-',$dte);
        $year = $arrdte[0];
        $path = GM_SERVER.'/H6gfaehgFhD7o/'.$year.'/';

        $contract = $order['contract'];
        $pieces = explode("-", $contract);

        if (($pieces[0]+0) != 0 ){
            $path .= $pieces[0].'-'.$pieces[1][0].'00-'.$pieces[1][0].'99/'.$contract;
        }
        elseif(mb_substr($contract,0,1,'utf-8') == 'Р'){
            $path .= 'Салон/'.$contract;
        }
        elseif(mb_substr($contract,0,1,'utf-8') == 'Г'){

            $path .= 'Гранд/ГР-'.$pieces[1];

        }
        else{
            $path .= 'Дилеры/'.$contract;
        }

//        $this->readAllFilesTest($path);
        $this->findDirClosedOrder($path);

        $files = $this->filelist;
//var_dump($files);die;
        $ip = $_SERVER['REMOTE_ADDR'];
        if($ip == "195.191.158.226"){
            $files = preg_replace('/195\.191\.158\.226/','192.168.0.99',$files);
        }

        $skip = array();

        $page = SITE_PATH.'views/order_closed.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }
    function readAllFiles($dir){
        $dirrect = substr($dir, 3);
        global $skip;
        $file_list = scandir($dir); // получаем список файлов и папок и заносим массив в переменную $file_list
        for($i = 0; isset($file_list[$i]); $i++){ // пока существуют элементы массива выполняем:
            if($file_list[$i] != '.' // если имя файла .
                && $file_list[$i] != '..' // если имя файла ..
                && $file_list[$i] != ''
            ){
                if(is_file($dir.'/'.$file_list[$i])){ // если файл существует
                    $skip[] = $dirrect.'/'.$file_list[$i]; // выводим адрес файла
                }else{
                    $this->readAllFiles($dir.'/'.$file_list[$i]);
                }
            }
        }
        return $skip;
    }

    function findDirClosedOrder($path){
        $page = @file_get_contents($path);//строковая переменная html код
        if(!(!$page)){
            preg_match_all(
                '/\[DIR\].+(\/\<)/',
                $page,
                $dires,
                PREG_SET_ORDER
            );
            if (count($dires) > 0) {
                $diresar = array();
                foreach ($dires as $dir) {
                    $str = explode(">", $dir[0]);
                    $dirname = substr(end($str), 0, -2);
                    $dirname = str_replace(' ', '%20', $dirname);
                    $newpath = $path . '/' . $dirname;

                    if(preg_match('/закр/iu', $dirname))
                        $this->readAllFilesTest($newpath);

//                    preg_match('/закр/i', $dirname);
//                    var_dump(preg_match("/а/i u", "ААА"));
//                    var_dump($pos);
//                    $pos = mb_stripos($dirname, 'закр',0,'UTF-8');

//                    if($pos!==false && $pos!=0){
//                        $this->readAllFilesTest($newpath);
//                    }
                    $this->findDirClosedOrder($newpath);

                }
            }
        }
    }

    function readAllFilesTest($path){

        $files = $this->filelist;
        //        var_dump($path); die;
        $page = @file_get_contents($path);//строковая переменная html код или false
//        var_dump($page);
        if(!(!$page)){
            preg_match_all(
                '/\[IMG\].+\.(jpg|JPG|JPEG|jpeg|png|bmp)/',
                $page,
                $matches,
                PREG_SET_ORDER
            );

//        var_dump($matches);
            foreach($matches as $match){
                $str = explode(">", $match[0]);
                $files[] = $path.'/'.end($str);
            }
//        var_dump($files);
//        die;

            $this->filelist = $files;
        }
    }

}
