<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 20.01.2016
 * Time: 17:41
 */

class Controller_claim {

    public function actionIndex(){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,2,3,55,58);
        $allow = Allowed::getAllowed('claim','Index');
        $allowed = explode(",", $allow);

        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $orderList = Order::getClaimsNoSum();//

        $page = SITE_PATH.'views/claim.php';
        include (SITE_PATH.'views/layout.php');

        return true;

    }
} 