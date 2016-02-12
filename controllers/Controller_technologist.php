<?php

class Controller_technologist {

    function actionSchedule(){
        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }
        $user = $_COOKIE['uid'];
        $user = 15;

 /*       if($ri!=6 && $ri!=7 && $ri!=1){
            header('Location: /'.SITE_DIR.'/schedule');
        }*/

        //выбрать заказы несчитанные
        $order_current = OrderStan::getTechNotEnd($user);
        $order_overdue = array();
        foreach($order_current as $key=>$order){
            if(strtotime($key)<strtotime('today')){
                foreach($order as $ord_one){
                    $order_overdue[]=$ord_one;
                }
                unset ($order_current[$key]);
            }
        }
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

        $page = SITE_PATH.'views/technologist.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionCloseTech(){

        $oid = $_POST['oid'];
        $today = date('Y-m-d', strtotime('today'));

        OrderStan::updateStanByParam('tech_date', $today, $oid);
        OrderStan::updateStanByParam('tech_end', '2', $oid);

        return true;
    }
} 