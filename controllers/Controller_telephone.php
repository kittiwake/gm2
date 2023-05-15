<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 23.03.2018
 * Time: 23:19
 */

class Controller_telephone {

    function actionIndex(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $ph = '79689716551';
        $client = Clients::getClientByPhone($ph);
//        var_dump($res); die;

        $callmen = $client['callmen'];
//        $data = array('roles' => array($callmen,"kittiwake"), 'customer_data' => $callerId);
        $resint = Users::getUsersByParam('user_login',$callmen);
        $int = $resint[0]['internal'];
        switch($int) {
            case '202':
                echo json_encode(array(
                    'redirect' => 2,//переадрес на 202 и 203
                    'caller_name' => ''
                ));
                break;
            case '203':
                echo json_encode(array(
                    'redirect' => 3,//переадрес на 202 и 203
                    'caller_name' => ''
                ));
                break;
            default:
                echo json_encode(array(
                    'redirect' => $int,//переадрес на 202 и 203
                    'caller_name' => ''
                ));
                break;
        }

die;
//        $script = '<script type="text/javascript" src="/scripts/socket.js"></script>';
        $page = SITE_PATH.'views/fortest.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionContacts(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $int = $_SESSION['internal'];

        $list = Clients::getAllClients();
//        foreach($list as $i=>$cl){
//            $ords = Order::getOrdersByParam('phone',$cl['phone']);
//            $orders = array();
//            foreach($ords as $ord){
//                $orders[] = $ord['contract'];
//            }
//            if($cl['phone2']!=''){
//                $ords = Order::getOrdersByParam('phone',$cl['phone2']);
//                $orders = array();
//                foreach($ords as $ord){
//                    $orders[] = $ord['contract'];
//                }
//            }
//            $list[$i]['orders'] = $orders;
//        }

        $page = SITE_PATH.'views/contacts.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionNewCall(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];
        $tel = (string)$_GET['callId'];
        $tel = '+'.substr($tel,1);
//        обработка формы
if(isset($_POST['submit'])){
    if(isset($_POST['namecl'])&&$_POST['namecl']!=''){
        $name = $_POST['namecl'];
        $tp2 = $_POST['phone2'];
        $tp3 = $_POST['phone3'];
        $istoch = $_POST['istochcl'];
        $mail = $_POST['mailcl'];
        $id = $_POST['clientid'];

        $res = Clients::updateParam($id,'name',$name);
        if($res){
            $res2 = $mail!=''?Clients::updateParam($id,'email',$mail):true;
            if($res2){
                //найти внутренний номер менеджера
//                $users = Users::getUsersByParam('user_login',$callmen);
//                $callnum = $users[0]['internal'];
                $res3 = Clients::updateParam($id,'callmen',$log);
                if($res3){
                    $res4 = $tp2!=''?Clients::updateParam($id,'phone2',$tp2):true;
                    if($res4){
                        $res5 = $tp3!=''?Clients::updateParam($id,'phone3',$tp3):true;
                        if($res5){
                            $res6 = Clients::updateParam($id,'istochnik',$istoch);
                        }
                    }
                }
            }
        }
    }else{
        $errn = 'Поле, обязательное для заполнения';
    }
}

//поиск заказчика
        $cust = Clients::getClientByPhone($tel);

        //пусто не должно быть, т.к. запись создана скриптом при поступившем звонке

        $clientinfo = $cust;

        if($cust['contracts']=='yes'){
            //искать договора, если есть
            $orders = Order::getOrdersByParam('custid',$cust['id']);
            foreach($orders as $k=>$order){
                $techus = Users::getUserById($order['technologist']);
                $tech = $techus['name'];
                $orders[$k]['technologist'] = $tech;
                //найти водителя
                $drpoisk = Logistic::getLogistByParam('point',$order['id']);
//                    var_dump($drpoisk);
                if(!empty($drpoisk)){
                    $drus = Users::getUserById($drpoisk[0]['driver']);
                    $driv = $drus['name'];
                    $orders[$k]['driver'] = $driv;
                }else{
                    $orders[$k]['driver'] = 'нет данных';
                }
                //найти запись в дизайнерах
                $pldispoisk = Plan_dis::getSamplesByParam('contract',$order['contract']);
                if(!empty($pldispoisk)){
                    $disus = Users::getUserById($pldispoisk[0]['dis']);
                    $men = $pldispoisk[0]['name_men'];
                }else{
                    //ищем по записи менеджера
                    $disus = Users::getUserById($order['designer']);
                    $men = 'Нет данных';
                }
                $orders[$k]['design'] = $disus['name'];
                $orders[$k]['manager'] = $men;
                $clientinfo['orders'] = $orders;

            }
        }

//        var_dump($clientinfo);die;
//        $script = '<script type="text/javascript" src="/scripts/socket.js"></script>';
//        $page = SITE_PATH.'views/newcalltest.php';
        include (SITE_PATH.'views/newcalltest.php');

        return true;
    }

    function actionNewCalls(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $res = Incall::getNewCall($int);

        echo json_encode($res);

        return true;
    }

    function actionGetinfo(){
        $tel = (string)$_POST['tel'];
        $tel = '+'.substr($tel,1);
//поиск заказчика
        $cust = Clients::getClientByPhone($tel);

        //пусто не должно быть, т.к. запись создана скриптом при поступившем звонке

        $clientinfo = $cust;

        if($cust['contracts']=='yes'){
            //искать договора, если есть
            $orders = Order::getOrdersByParam('custid',$cust['id']);
            foreach($orders as $k=>$order){
                $techus = Users::getUserById($order['technologist']);
                $tech = $techus['name'];
                $orders[$k]['technologist'] = $tech;
                //найти водителя
                $drpoisk = Logistic::getLogistByParam('point',$order['id']);
//                    var_dump($drpoisk);
                if(!empty($drpoisk)){
                    $drus = Users::getUserById($drpoisk[0]['driver']);
                    $driv = $drus['name'];
                    $orders[$k]['driver'] = $driv;
                }else{
                    $orders[$k]['driver'] = 'нет данных';
                }
                //найти запись в дизайнерах
                $pldispoisk = Plan_dis::getSamplesByParam('contract',$order['contract']);
                if(!empty($pldispoisk)){
                    $disus = Users::getUserById($pldispoisk[0]['dis']);
                    $men = $pldispoisk[0]['name_men'];
                }else{
                    //ищем по записи менеджера
                    $disus = Users::getUserById($order['designer']);
                    $men = 'Нет данных';
                }
                $orders[$k]['design'] = $disus['name'];
                $orders[$k]['manager'] = $men;
                $clientinfo['orders'] = $orders;

            }
        }

        echo json_encode($clientinfo);
//        echo json_encode($tel);

        return true;
    }

    function  actionCall($phone){
        $phone = substr($phone,1);
        $new = false;
        $res = Clients::getClientByPhone($phone);
        if(!$res){
            $new = true;
            //добавить запись в базу
            $addid = Clients::addClient($phone);//id новой записи
        }else{
            $name = $res['name'];
            if($res['contracts']=='yes'){
                $res2 = Order::getOrdersByParam('custid',$res['id']);
                foreach($res2 as $k=>$order){
                    $techus = Users::getUserById($order['technologist']);
                    $tech = $techus['name'];
                    $res2[$k]['technologist'] = $tech;
                    //найти водителя
                    $drpoisk = Logistic::getLogistByParam('point',$order['id']);
//                    var_dump($drpoisk);
                    if(!empty($drpoisk)){
                        $drus = Users::getUserById($drpoisk[0]['driver']);
                        $driv = $drus['name'];
                        $res2[$k]['driver'] = $driv;
                    }else{
                        $res2[$k]['driver'] = 'нет данных';
                    }
                    //найти запись в дизайнерах
                    $pldispoisk = Plan_dis::getSamplesByParam('contract',$order['contract']);
                    if(!empty($pldispoisk)){
                        $disus = Users::getUserById($pldispoisk[0]['dis']);
                        $men = $pldispoisk[0]['name_men'];
                    }else{
                        //ищем по записи менеджера
                        $disus = Users::getUserById($order['designer']);
                        $men = 'Нет данных';
                    }
                    $res2[$k]['design'] = $disus['name'];
                    $res2[$k]['manager'] = $men;

                }
//                var_dump($res2);
            }
        }
//        var_dump($res);

        include (SITE_PATH.'views/infoclient.php');

        return true;
    }

    function actionChangeClientContr(){
        $contr = $_POST['val'];
        $id = $_POST['idclient'];

        $res = Clients::updateParam($id,'contracts',$contr);
        echo $res;

        return true;
    }

    function actionChangeClientData(){
//        'idclient=' + clid + '&name=' + name + '&istoch=' + istoch + '&mail=' + mail+ '&callmen=' + login + '&tp2=' + tp2 + '&tp3=' + tp3,
        $id = $_POST['idclient'];
        $name = $_POST['name'];
        $istoch = $_POST['istoch'];
        $mail = $_POST['mail'];
        $callmen = $_POST['callmen'];
        $tp2 = $_POST['tp2'];
        $tp3 = $_POST['tp3'];

        $res = Clients::updateParam($id,'name',$name);
        if($res){
            $res2 = $mail!=''?Clients::updateParam($id,'email',$mail):true;
            if($res2){
                //найти внутренний номер менеджера
                $users = Users::getUsersByParam('user_login',$callmen);
                $callnum = $users[0]['internal'];
                $res3 = Clients::updateParam($id,'callmen',$callnum);
                if($res3){
                    $res4 = $tp2!=''?Clients::updateParam($id,'phone2',$tp2):true;
                    if($res4){
                        $res5 = $tp3!=''?Clients::updateParam($id,'phone3',$tp3):true;
                        if($res5){
                            $res6 = Clients::updateParam($id,'istochnik',$istoch);
                        }
                    }
                }
            }
        }
        echo isset($res6)?$res6:'';

        return true;
    }

    function actionFindClient(){
//        'name='+name
        $name = $_POST['name'];
        $res = Clients::getClientsLikeName($name);
        echo json_encode($res);

        return true;
    }

    function actionAddPhoneToName(){
//        'id=' + clid + '&phone=' + tel + '&previd=' + previd,
        $id = $_POST['id'];
//        $tel = (string)$_POST['tel'];
//        $tel = '+'.substr($tel,1);

        $phone = '+'.substr($_POST['phone'],1);
        $previd = $_POST['previd'];
        $phone = str_replace('/\D/g','',$phone);
        $res = Clients::getClientById($id);
        if($res['phone2']=='') $pole = 'phone2';
        elseif($res['phone3']=='') $pole = 'phone3';
        $res2 = Clients::updateParam($id,$pole,$phone);
        if($res2){
            $res3 = Clients::delClientById($previd);
        }
        echo $res3;
//        echo $phone;
        return true;
    }

    function actionCheckNotifyEnd(){
        $phone = $_POST['phine'];
        $res = Incall::getLastNotify($phone);
        echo json_encode($res);

        return true;
    }
}