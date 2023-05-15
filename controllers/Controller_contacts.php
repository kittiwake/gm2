<?php

class Controller_contacts {

    function actionIndex(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $int = $_SESSION['internal'];

//        список получателей задачи
        $usersres = Users::getUsersByParam('validation',1);
        $users = array();
        foreach($usersres as $user){
            if($user['user_login']==''||$user['name']=='') continue;
            if($user['user_right']!=0){
                $users[$user['user_login']] = $user['name'];
            }
        }
        asort($users);

        $list = Clients::getLeadClients();
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

        $style = '<link rel="stylesheet" href="/css/todo.css" title="normal" type="text/css" media="screen" />';
        $script2 = '<script type="text/javascript" src="/scripts/contacts.js"></script>';
        $page = SITE_PATH.'views/contacts.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionAdd(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $clid = 0;
        $clientarr = array(
            'name'=>'',
            'callmen'=>$log,
            'phone'=>'',
            'phone2'=>'',
            'phone3'=>'',
            'email'=>'',

        );

        $script2 = '<script type="text/javascript" src="/scripts/clientinfo.js"></script>';
        $style = '<link rel="stylesheet" href="/css/iteminfo.css" title="normal" type="text/css" media="screen" />';
        $page = SITE_PATH.'views/clientinfo.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionClient($clid){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $clientarr = Clients::getClientById($clid);

//        var_dump($clientarr);die;

        $script2 = '<script type="text/javascript" src="/scripts/clientinfo.js"></script>';
        $style = '<link rel="stylesheet" href="/css/iteminfo.css" title="normal" type="text/css" media="screen" />';
        $page = SITE_PATH.'views/clientinfo.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionAddChange(){

        $id = (isset($_POST['id']))?$_POST['id']:0;
        $clname = (isset($_POST['clname']))?$_POST['clname']:'';
        $callman = (isset($_POST['callman']))?$_POST['callman']:'';
        $clemail = (isset($_POST['clemail']))?$_POST['clemail']:'';
        $clphone = (isset($_POST['clphone']))?$_POST['clphone']:'';
        $clphone2 = (isset($_POST['clphone2']))?$_POST['clphone2']:'';
        $clphone3 = (isset($_POST['clphone3']))?$_POST['clphone3']:'';
        $stan = (isset($_POST['stan']))?$_POST['stan']:'';

        if($id==0){
//            добавить нового клиента
            if($callman!=''){
                $callman = $_SESSION['login'];
            }
            $res = Clients::addClientHand($clname,$clphone,$clphone2,$clphone3,$clemail,$callman);
        }
        else{
//            редактировать данные
            if($clname!=''){
                $res = Clients::updateParam($id,'name',$clname);
            }
            if($callman!=''){
                $res = Clients::updateParam($id,'callmen',$callman);
            }
            if($clemail!=''){
                $res = Clients::updateParam($id,'email',$clemail);
            }
            if($clphone!=''){
                $res = Clients::updateParam($id,'phone',$clphone);
            }
            if($clphone2!=''){
                $res = Clients::updateParam($id,'phone2',$clphone2);
            }
            if($clphone3!=''){
                $res = Clients::updateParam($id,'phone3',$clphone3);
            }
            if($stan!=''){
                $res = Clients::updateParam($id,'stan',$stan);
            }
            echo true;
        }

        return true;
    }

    function actionCheckDublContact(){

        $phone = $_POST['phone'];
//        $phone = $_GET['phone'];
        $res = Clients::getClientByPhone($phone);
        if(!!$res&&$res['stan']!='delete'){
            echo $res['id'];
        }
        else{
            echo $res;
        }
        return true;
    }
} 