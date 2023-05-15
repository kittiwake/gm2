<?php

class Controller_sms {

    public function actionSend($oid){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        var_dump($oid);

//        $page = SITE_PATH.'views/claim.php';
 //       include (SITE_PATH.'views/layout.php');

        return true;

    }
} 