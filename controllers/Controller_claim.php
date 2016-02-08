<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 20.01.2016
 * Time: 17:41
 */

class Controller_claim {

    public function actionIndex(){

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/auth/showAuth');
        }

        $orderList = Order::getClaimsNoSum();//

        $page = SITE_PATH.'views/claim.php';
        include (SITE_PATH.'views/layout.php');

        return true;

    }
} 