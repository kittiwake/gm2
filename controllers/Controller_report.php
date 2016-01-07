<?php

class Controller_report
{
    function actionAssembly()
    {

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];

        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/');
        }

        $begin = '';
        $end = '';

        if (isset ($_POST['submit'])) {
            if (isset($_POST['begin']) && isset($_POST['end'])) {
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
                        $order['sborka_end_date'] = $one['sborka_end_date'];
                        //выделить безнал и рекламации
                        if($order['beznal']==1 || $order['rassr']==1){
                            $beznal[$order['collector']][] = $order;
                        }elseif(Datas::isRekl($order['contract'])){
                            $rekl[$order['collector']][] = $order;
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
                                $dillerskie[$order['collector']][] = $order;
                            }else{
                                $odderList[$order['collector']][] = $order;
                            }
                        }
                    }
                }

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
}