<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 21.06.2018
 * Time: 16:41
 */

class Controller_leads {

    function actionIndex(){

        return true;
    }

    function actionAdd(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $clid = $_GET['clid'];
        $last_contr = Sdelki::getLastContracts();


        //UPDATE `u0315626_graf`.`last_gen` SET `val` = '23' WHERE `last_gen`.`key` = 'seriya';

//        var_dump($last_contr);die;
        $page = SITE_PATH.'views/leadinfo.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionItem($leadid){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        $leadarr = Sdelki::getSdelkaById($leadid);

        $page = SITE_PATH.'views/leadinfo.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }
} 