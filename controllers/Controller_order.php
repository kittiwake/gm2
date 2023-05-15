<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 11.01.2016
 * Time: 13:10
 */

class Controller_order {

    private $filelist = array();
    
    function actionIndex1($oid){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('order','Index');
        $allowed = explode(",", $allow);

        if($ri != 1){
            die("Нет доступа к этой странице!");
        }
        $order = Order::getOrderById($oid);
        $order_stan = OrderStan::getOrdersByPole('oid', $oid);
        
        $addr_arr = explode(',', $order['adress']);
        foreach($addr_arr as $addr_it){
            $pos = strpos($addr_it, 'эт');
            if($pos){
                preg_match('/\d+/', $addr_it, $matches);
                $fl = $matches[0];
                $w = $order_stan[$oid]['weight'];
                var_dump($fl * $w * 4);
            }
        }
        
       // debug(explode(',', $order['adress']));
        
        return true;
    }

    function actionIndex($oid){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $allow = Allowed::getAllowed('order','Index');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $zagol = array('Просчет','Материал','Распил','ЧПУ','Кромка','Криволинейка','Присадка','Гнутье','Эмаль','ПВХ','Шпон','Фотопечать','Пескоструй','Витраж','oracal','Фасады','Упакован','Отгружен');
        $db = array("tech_end","mater","raspil","cpu","kromka","krivolin","pris_end","gnutje","emal","pvh","shpon","photo","pesok","vitrag","oracal","fas","upak_end","otgruz_end");
        $dbdate = array("tech_date",null,"raspil_date","cpu_date","kromka_date","krivolin_date","pris_date","gnutje_date","emal_date","pvh_date","shpon_date","photo_date","pesok_date","vitrag_date","oracal_date","fas_date","upak_date","plan");

        $order = Order::getOrderById($oid);
        $order_stan = OrderStan::getOrdersByPole('oid', $oid);
        $stan = $order_stan[$oid];

//debug($stan); die;

        //путь к файлам
        $dte = $order_stan[$oid]['plan'];
        $contract = $order['contract'];
        if($ri == 20){
            $order['sum'] = round($order['sum']/3.5);
            $order['prepayment'] = round($order['prepayment']/3.5);
            $order['rebate'] = round($order['rebate']/3.5);
            $order['sumcollect'] = round($order['sumcollect']/3.5);
        }
//var_dump($order);die;
        $path = GM_SERVER.'/H6gfaehgFhD7o';
        $path2 = Datas::getPathFromYear($dte,$contract);

        $path .= $path2;
//var_dump($path);die;
//        $this->readAllFilesTest($path);
//        $this->readAllDirs($path);
//
//        $files = $this->filelist;
////        var_dump($files);
////        die;
//        //во всем массиве заменить GM_SERVER если запрос с $ip == "195.191.158.226"
//        $ip = $_SERVER['REMOTE_ADDR'];
//        if($ip == "195.191.158.226"){
//            $files = preg_replace('/195\.191\.158\.226/','192.168.0.99',$files);
//        }


        $us_dis = Users::getUserById($order['designer']);
        $dis = $us_dis['name'];
        $us_tech = Users::getUserById($order['technologist']);
        $tech = $us_tech['name'];
        $res = Logistic::getLogistsByParam('point',$oid);
//        var_dump($res[count($res)-1]['driver']);die;
        if($res&&$res[count($res)-1]['driver']!='0'){
            $driver_id = $res[count($res)-1]['driver'];
            if($driver_id != 0){
                $us_driver = Users::getUserById($driver_id);
                $driver = $us_driver['name'];
                $driver_phone = $us_driver['tel'];
                $drivertosms = $driver.'(моб.:+'.$driver_phone.')';
            }
        }
        else{
            $driver = 'Не назначен';
            $drivertosms = '';
        }

        //сборщик
        $mount = Mounting::getMountingLast($oid);
        $measure = Mounting::getMeasureLast($oid);
        if(!$measure) $date_measure = '';
        else $date_measure = date("d.m.y", strtotime($measure[0]['m_date']));

        if(!$mount){
            $colltosms = '';
            $date_mount = '';
        }else{
            $colltosms = '';
            $colls = array();
            foreach($mount as $eachmount){
                $coll_id = $eachmount['uid'];
                $user = Users::getUserById($coll_id);
                $coll = $user['name'];
                $colls[]=Datas::nameAbr($coll);
                $m_phone = $user['tel'];
                $colltosms .= ' '.$user['name'].'(моб.:+'.$user['tel'].')';
                $date_mount = date("d.m.y", strtotime($eachmount['m_date']));
            }
        }
        $button = '<button onclick="showFormAddingMount('.$oid.', \'assembly\')">Назначить</button>';
        $button_z = '<button onclick="showFormAddingMount('.$oid.', \'measure\')">Назначить</button>';

        //шаблоны смс
        $sample = Sms::getSamples();
        $search = array(
            '%name%',
            '%con%',
            '%date%',
            '%m_date%',
            '%collector%',
            '%name_fathname%',
            '%driver%'
        );
        $nfn = Datas::nameFathername($order['name']);
        $replace = array(
            $order['name'],
            $order['contract'],
            date("d.m.y", strtotime($stan['plan'])),
            $date_mount,
            $colltosms,
            $nfn,
            $drivertosms
        );
        $sample_sms = array();
        $sample_email = array();
        foreach ($sample as $key=>$sampleone){
            $str = $sampleone['text_sms'];
            $newstr = str_replace($search,$replace,$str);
            if($sampleone['mes_type'] == 'sms'){
                $sample_sms[$key] = $sampleone;
                $sample_sms[$key]['text_sms'] = $newstr;
            }else{
                $sample_email[$key] = $sampleone;
                $sample_email[$key]['text_sms'] = $newstr;
            }
        }
        $errorsms = array();
        $notes = Notes::getNotesByOid($oid);
        if(isset($_POST['sendsms'])){
            $phone = $_POST['phone'];
            $message = $_POST['message'];
            $sms = Sms::send($phone, $message);
            switch ($sms){
                case 100:
                    $errorsms[]='Сообщение отправлено';
                    Sms::save($oid, $message);
                    break;
                case 201: $errorsms[]='Не хватает средств на лицевом счету';
                    break;
                case 202: $errorsms[]='Неправильно указан получатель';
                    break;
                case 203: $errorsms[]='Нет текста сообщения';
                    break;
                case 205: $errorsms[]='Сообщение слишком длинное (превышает 8 СМС)';
                    break;
                case 206: $errorsms[]='Будет превышен или уже превышен дневной лимит на отправку сообщений';
                    break;
                case 207: $errorsms[]='На этот номер (или один из номеров) нельзя отправлять сообщения';
                    break;
                case 220: $errorsms[]='Сервис временно недоступен, попробуйте чуть позже';
                    break;
                default: $errorsms[]='Сообщение не отправлено, обратитесь к администратору';
            }
        }

        if(isset($_POST['sendmail'])){
            $email = $_POST['email'];
            $emessage = $_POST['emessage'];
            $tema = $sample[$_POST['tema']]['subject_sms'];
            $searchm = array(
                '%link%'
            );
            $replacem = array(
                '<a href="http://otzovik.com/reviews/mebelnaya_fabrika_galereya_mebeli">данном ресурсе</a>',
            );
            $text = str_replace($searchm,$replacem,$emessage);

            $ms = Sms::sendEmail($email,$tema,$text);
            switch ($ms){
                case true:
                    $errorsms[]='Сообщение успешно принято для доставки';
                    Sms::save($oid, $emessage, 'email');
                    break;
                case false: $errorsms[]='Ошибка! Сообщение не отправлено';
                    break;
                default: $errorsms[]='Ошибка! Сообщение не отправлено';
            }
        }
if(isset($_GET['printveaw']) && $_GET['printveaw']==1){
//    var_dump($order);die;
    include (SITE_PATH.'views/orderdelivprint.php');
}else{
    // 3 файла для создания pdf файла
    // debug($order);
    $script = '
    <script type="text/javascript" src="/scripts/pdfmake.min.js"></script>
    <script type="text/javascript" src="/scripts/vfs_fonts.js"></script>
    <script type="text/javascript" src="/scripts/pdfscript.js"></script>
';
    $script2 = '<script type="text/javascript" src="/scripts/assembly.js"></script>';
    $page = SITE_PATH.'views/order.php';
    include (SITE_PATH.'views/layout.php');
}
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
//        return $skip;
        return $dirrect;
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

    function readAllDirs($path){
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
                    $this->readAllFilesTest($newpath);
                    $this->readAllDirs($newpath);
                }
            }
        }
    }

    function actionTest($oid){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $zagol = array('Просчет','Материал','Распил','ЧПУ','Кромка','Криволинейка','Присадка','Гнутье','Эмаль','ПВХ','Фотопечать','Пескоструй','Витраж','oracal','Фасады','Упакован','Отгружен');
        $db = array("tech_end","mater","raspil","cpu","kromka","krivolin","pris_end","gnutje","emal","pvh","photo","pesok","vitrag","oracal","fas","upak_end","otgruz_end");

        $order = Order::getOrderById($oid);
        $order_stan = OrderStan::getOrdersByPole('oid', $oid);
        $stan = $order_stan[$oid];

        //путь к файлам
        $dte = $order_stan[$oid]['plan'];
        $arrdte = explode('-',$dte);
        $year = $arrdte[0];
        $path = '../H6gfaehgFhD7o/'.$year.'/';
//        $url = '../baza/%D0%97%D0%90%D0%9A%D0%90%D0%97%D0%AB/'.$year.'/';//ЗАКАЗЫ

        $contract = $order['contract'];
        $pieces = explode("-", $contract);

        if (($pieces[0]+0) != 0 ){
            $path .= $pieces[0].'-'.$pieces[1][0].'00-'.$pieces[1][0].'99/'.$contract;
//            $url .= $pieces[0].'-'.$pieces[1][0].'00-'.$pieces[1][0].'99/'.$contract;
        }
        elseif(mb_substr($contract,0,1,'utf-8') == 'Р'){
            $path .= 'Салон/'.$contract;//Салон
//            $url .= '%D0%A1%D0%B0%D0%BB%D0%BE%D0%BD/'.$contract;//Салон
        }
        elseif(mb_substr($contract,0,1,'utf-8') == 'Г'){

            $path .= 'Гранд/ГР-'.$pieces[1];//Гранд/ГР
//            $url .= '%D0%93%D1%80%D0%B0%D0%BD%D0%B4%2F%D0%93%D0%A0-'.$pieces[1];//Гранд/ГР

        }
        else{
            $path .= 'Дилеры/'.$contract;//Дилеры
//            $url .= '%D0%94%D0%B8%D0%BB%D0%B5%D1%80%D1%8B/'.$contract;//Дилеры
        }
        if(is_dir($path)){
            $skip = array();
            $files = $this->readAllFilesTest($path);

        }

        $us_dis = Users::getUserById($order['designer']);
        $dis = $us_dis['name'];
        $us_tech = Users::getUserById($order['technologist']);
        $tech = $us_tech['name'];

        //сборщик
        $mount = Mounting::getMountingLast($oid);
        if(!$mount){
            $colltosms = '';
            $date_mount = '';
        }else{
            $colltosms = '';
            foreach($mount as $eachmount){
                $coll_id = $eachmount['uid'];
                $user = Users::getUserById($coll_id);
                $coll = $user['name'];
                $m_phone = $user['tel'];
                $colltosms .= ' '.$user['name'].'(моб.:+'.$user['tel'].')';
                $date_mount = date("d.m.y", strtotime($eachmount['m_date']));
            }
        }

        //шаблоны смс
        $sample = Sms::getSamples();
        $search = array(
            '%name%',
            '%con%',
            '%date%',
            '%m_date%',
            '%collector%'
        );
        $replace = array(
            $order['name'],
            $order['contract'],
            date("d.m.y", strtotime($stan['plan'])),
            $date_mount,
            $colltosms
        );
        foreach ($sample as $key=>$sampleone){
            $str = $sampleone['text_sms'];
            $newstr = str_replace($search,$replace,$str);
            $sample[$key]['text_sms'] = $newstr;
        }

        $notes = Notes::getNotesByOid($oid);
        if(isset($_POST['sendsms'])){
            $phone = $_POST['phone'];
            $message = $_POST['message'];
            $sms = Sms::send($phone, $message);
            $errorsms = array();
            switch ($sms){
                case 100:
                    $errorsms[]='Сообщение отправлено';
                    Sms::save($oid, $message);
                    break;
                case 201: $errorsms[]='Не хватает средств на лицевом счету';
                    break;
                case 202: $errorsms[]='Неправильно указан получатель';
                    break;
                case 203: $errorsms[]='Нет текста сообщения';
                    break;
                case 205: $errorsms[]='Сообщение слишком длинное (превышает 8 СМС)';
                    break;
                case 206: $errorsms[]='Будет превышен или уже превышен дневной лимит на отправку сообщений';
                    break;
                case 207: $errorsms[]='На этот номер (или один из номеров) нельзя отправлять сообщения';
                    break;
                case 220: $errorsms[]='Сервис временно недоступен, попробуйте чуть позже';
                    break;
                default: $errorsms[]='Сообщение не отправлено, обратитесь к администратору';
            }
        }
        $page = SITE_PATH.'views/ordertest.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionAddnote(){
        $oid = $_POST['oid'];
        $note = $_POST['note'];

        Notes::setNote($oid, $note);

        return true;
    }

    function actionChangeStan(){
        $oid = $_POST['oid'];
        $p = $_POST['table'];
        $val = $_POST['val'];
        $bd = array("tech_end","mater","raspil","cpu","kromka","krivolin","pris_end","gnutje","emal","pvh","shpon","photo","pesok","vitrag","oracal","fas","upak_end","otgruz_end");
        $pole = $bd[$p];

        OrderStan::updateStanByParam($pole, $val, $oid);

        return true;
    }

    function actionTransfer(){
        $oid = $_POST['oid'];
        $date = $_POST['date'];

        $res = OrderStan::updateStanByParam('plan', $date, $oid);
echo $res;
        return true;
    }

    function actionChangeTermin(){
        $oid = $_POST['oid'];
        $date = $_POST['date'];

        $date = preg_replace('/(\d{1,2})-(\d{1,2})-(\d{4})/','\3-\2-\1',$date);

        $res = Order::updateOrdersByParam('term', $date, $oid);

        echo $res;

        return true;
    }

    function actionChangeSum(){
        $oid = $_POST['oid'];
        $sum = $_POST['sum'];
        $pole = $_POST['pole'];
        if($pole=='weight'){
            $res1 = ($sum!='')?OrderStan::updateStanByParam('weight', $sum, $oid):false;
        }else{
            $res1 = ($sum!='')?Order::updateOrdersByParam($pole,$sum,$oid):false;
        }
        
        echo $res1?$sum:false;

        return true;
    }

    function actionChangeContract(){
        $oid = $_POST['oid'];
        $con = $_POST['con'];
        $find = Order::getOrdersByParam('contract',$con);
        if(!empty($find)){
            echo 'error';
        }
        else {
            $res = Order::updateOrdersByParam('contract',$con,$oid);
            echo $res;
        }

        return true;
    }

    function actionDeleteOrder(){

        $oid = $_POST['oid'];
        $res1=Order::delOrderById($oid);
        if($res1==true){
            OrderStan::delOrderByOid($oid);
            Mounting::delOrderByOid($oid);
            Material::delOrderByOid($oid);
            Sms::delOrderByOid($oid);
            Notes::delOrderByOid($oid);
            echo '1';
        }
        return true;
    }

    function actionSaveChanges(){
        $data = array();

        if(isset($_POST['name'])) $data['name'] = $_POST['name'];
        if(isset($_POST['adress'])) $data['adress'] = $_POST['adress'];
        //удалить координату
        if(isset($_POST['phone'])) $data['phone'] = $_POST['phone'];
        if(isset($_POST['email'])) $data['email'] = $_POST['email'];
        if(isset($_POST['uid'])) $data['designer'] = $_POST['uid'];
        if(isset($_POST['archive'])) $data['archive'] = $_POST['archive'];
        if(isset($_POST['attention'])) $data['attention'] = $_POST['attention'];
        $oid = $_POST['oid'];
        
        // if(isset($_GET['attention'])) $data['attention'] = $_GET['attention'];
        // $oid = $_GET['oid'];
        $res = true;
        foreach($data as $key=>$val){
            $res1 = Order::updateOrdersByParam($key,$val,$oid);
            $res = $res&&$res1;
        }

        echo $res;

        return true;
    }

    function actionChangeCoords(){
        $oid = $_POST['oid'];
        $ll = $_POST['latlng'];

        $res = Order::updateOrdersByParam('latlng',$ll,$oid);
        echo $res;
        return true;
    }

}