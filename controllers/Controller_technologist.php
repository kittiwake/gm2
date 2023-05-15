<?php

class Controller_technologist {

    function actionSchedule(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $user = $_SESSION['uid'];

        $allowed = array(1,6,7,21);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        //   $user = 15;

 /*       if($ri!=6 && $ri!=7 && $ri!=1){
            header('Location: /schedule');
        }*/

        //выбрать заказы несчитанные
        $order_current = OrderStan::getTechNotEnd($user);
        $order_overdue = array();
        foreach($order_current as $key=>$order){
            if(strtotime($key)<strtotime('today')){
                foreach($order as $ord_one){
                    $path = Datas::getPathFromYear($ord_one['plan'],$ord_one['contract']);
                    $ord_one['path'] = $path;
                    $order_overdue[]=$ord_one;
                }
                unset ($order_current[$key]);
            }else{
                foreach($order as $i=>$ord_one){
                    $path = Datas::getPathFromYear($ord_one['plan'],$ord_one['contract']);
                    $order_current[$key][$i]['path'] = $path;
                }
            }
        }
//        var_dump($order_current);
//        var_dump($order_overdue);
//        die;
   //     var_dump($order_current); die;
        //заказы закрытые за последний и текущий месяц
        $order_end = array();
        $claim_end = array();
        $order_list = OrderStan::getTechEnd($user);
        //перебор и сортировка
        $m = date('m');
        $month_of_year = array(
            '01'=>'январь',
            '02'=>'февраль',
            '03'=>'март',
            '04'=>'апрель',
            '05'=>'май',
            '06'=>'июнь',
            '07'=>'июль',
            '08'=>'август',
            '09'=>'сентябрь',
            '10'=>'октябрь',
            '11'=>'ноябрь',
            '12'=>'декабрь'
        );
        foreach($month_of_year as $num => $name){
            $sum_order[$name] = 0;
            $sum_claim[$name] = 0;
            $count_order[$name] = 0;
            $count_claim[$name] = 0;
        }

        foreach($order_list as $order_one){
            $pieces = explode('-', $order_one['tech_date']);
            $mbd = $pieces[1];
            if(Datas::isRekl($order_one['contract'])){
                $claim_end[$month_of_year[$mbd]][] = $order_one;
                $sum_claim[$month_of_year[$mbd]] += $order_one['sum'];
                $count_claim[$month_of_year[$mbd]] ++;
            }else{
                $order_end[$month_of_year[$mbd]][] = $order_one;
                $sum_order[$month_of_year[$mbd]] += $order_one['sum'];
                $count_order[$month_of_year[$mbd]] ++;
            }
        }
        //список сборщиков и дизайнеров с номерами телефонов
        $disList = Users::getUserByPost(5);
        $colList = Users::getUserByPost(17);

        $script = '<script type="text/javascript" src="/scripts/technologist.js"></script>';
        $page = SITE_PATH.'views/technologist.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionCloseTech(){

        $oid = $_GET['oid'];
        $weight = $_GET['weight'];
        $today = date('Y-m-d', strtotime('today'));

        $res1 = OrderStan::updateStanByParam('tech_date', $today, $oid);
        $res2 = OrderStan::updateStanByParam('tech_end', '2', $oid);
        $res3 = OrderStan::updateStanByParam('weight', $weight, $oid);

        if($res1 && $res2 && $res3){
            header('Location: /technologist/schedule');

        };

        return true;
    }
} 