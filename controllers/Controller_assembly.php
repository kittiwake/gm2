<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 26.11.2015
 * Time: 12:29
 */

class Controller_assembly{
    function actionPlan() {

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];


        if(isset($_POST['submit'])) {
            if(isset ($_POST['numord'])){
                $num = $_POST['numord'];
            }
            for ($i=0; $i<$num; $i++){
                $oid = $_POST['c'.$i];
                $text_date = 'd'.$oid;
                $sel_coll = 'sb'.$oid;

                if (isset($_POST[$text_date])&&!empty($_POST[$text_date])) {
                    //внести изменениия в базу
                    $datedb = Datas::dateToDb($_POST[$text_date]);
                    OrderStan::updateStanByParam('sborka_date',$datedb,$oid);
                }
                if (isset($_POST[$sel_coll])&&$_POST[$sel_coll]!='0') {
                    //внести изменениия в базу
                    Order::updateOrdersByParam('collector',$_POST[$sel_coll],$oid);
                }
            }
        }


//все незакрытые заказы
       $nesobr = OrderStan::getOrdersByPole('sborka_end','0');
        $sborki = array();
        $plansb = array();

        foreach($nesobr as $key=>$value){
            $oid = $value['oid'];
            $order = Order::getOrderById($oid);
            if($order == null){
                unset($nesobr[$key]);
            }else{
                $name_sb = 0;

                if($order['collector']!='0'){
                    $us = Users::getUserById($order['collector']);
                    $name_sb = Datas::nameAbr($us['name']);

                }
            }

            if($value['sborka_date']!='0000-00-00'&&$order['collector']!=0){
                //имя сборщика $order['collector']
                if(!array_key_exists($value['sborka_date'], $sborki)){
                    $sborki[$value['sborka_date']] = array();
                }
                $sborki[$value['sborka_date']][]=array('oid'=>$key, 'con'=>$order['contract'], 'coll'=>$name_sb);
            }elseif($order['contract']!=null){
                $plansb[]=array('oid'=>$key, 'con'=>$order['contract'], 'sbdate'=>$value['sborka_date'], 'coll'=>$name_sb,'otgruz'=>$value['otgruz_end']);
            }
        }
        $plansb = Datas::sortArrayByVal($plansb,'con');
        $plansb = Datas::sortArrayByVal($plansb,'otgruz');
        $count = count($plansb);

        //получить список сборщиков
        $userList = User_post::getUsersByPost(17);
        $sborList = array();
        foreach ($userList as $uid){
            $datasb = Users::getUserById($uid['uid']);
            if($datasb['operative'] == 1){
                $abr = Datas::nameAbr($datasb['name']);
                $sborList[] = array('uid' => $datasb['id'], 'name' => $abr);
            }
        }
        ksort($sborki);



            $page = SITE_PATH.'views/assembly.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionGetName(){

        //получить id сборщиков
        $list_id = User_post::getUsersByPost('17');
        //узнать их имена
        foreach($list_id as $post){
            $user = Users::getUserById($post['uid']);
            $collectors[$post['uid']] = $user['name'];
        }
        echo json_encode($collectors);


        return true;
    }
}
?>