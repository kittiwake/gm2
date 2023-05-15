<?php

class Controller_test {


    function actionIndex(){
                $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $user = $_SESSION['uid'];
        // oid='.$oid
        if(isset($_GET['oid'])){
            //получить номер заказа
            $oid = $_GET['oid'];
            $order = Order::getOrderById($oid);
            $cont = $order['contract'];
        }
        
        // $script = '<script type="text/javascript" src="/scripts/technologist.js"></script>';
        $page = SITE_PATH.'views/test.php';
        include (SITE_PATH.'views/layout.php');

        return true; 
        
    }
}