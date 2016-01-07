<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 07.10.2015
 * Time: 20:39
 */

class Controller_new {
    function actionIndex()
    {

        $ri = $_COOKIE['ri'];
        $log = $_COOKIE['login'];
        if(!isset($ri)){
            header('Location: /'.SITE_DIR.'/');
        }

        $contract='';
        $con_date='';
        $name = '';
        $prod = '';
        $termin = '';
        $otkr = 0;
        $sum = '';
        $rassr = 0;
        $beznal = 0;
        $pred = '';
        $dis ='';
        $adress = '';
        $phone = '';
        $note = '';
        //получить список дизайнеров
        $userList = User_post::getUsersByPost(5);
        $disList = array();
        foreach ($userList as $disid){
            $datadis = Users::getUserById($disid['uid']);
            if($datadis['operative'] == 1){
                $disList[] = array('uid' => $datadis['id'], 'name' => $datadis['name']);
            }
        }
    //    var_dump($disList);


        if(isset($_POST['submit'])) {
            //текстовые поля
            if (isset($_POST['num'])) {
                $contract = $_POST['num'];
            }
            if (isset($_POST['con_date'])) {
                $con_date = $_POST['con_date'];
            }
            if (isset($_POST['name'])) {
                $name = $_POST['name'];
            }
            if (isset($_POST['prod'])) {
                $prod = $_POST['prod'];
            }
            if (isset($_POST['term'])) {
                $termin = $_POST['term'];
            }
            if (isset($_POST['sum'])) {
                $sum = str_replace(",", ".", $_POST['sum']);
            }
            if (isset($_POST['pred'])) {
                $pred = str_replace(",", ".", $_POST['pred']);
            }
            if (isset($_POST['adress'])) {
                $adress = $_POST['adress'];
            }
            if (isset($_POST['phone'])) {
                $phone = $_POST['phone'];
            }
            if (isset($_POST['note'])) {
                $note = $_POST['note'];
            }
//чекбоксы
            if (isset($_POST['beznal'])) {
                $beznal = 1;
            }
            if (isset($_POST['otkr'])) {
                $otkr = 1;
            }
            if (isset($_POST['rassr'])) {
                $rassr = 1;
            }
//селект
            if(isset($_POST['dis'])){
                $dis = $_POST['dis'];
            }


            $errors = false;
            if (!Datas::checkPole($contract)) {
                $errors[] = 'Не введен номер заказа';
            }
            if (!Datas::checkPole($name)) {
                $errors[] = 'Как обращаться к заказчику?';
            }
            if (!Datas::checkPole($termin) && $otkr == 0) {
                $errors[] = 'Не указан срок договора';
            }
            if (!Datas::checkPole($sum)) {
                $errors[] = 'Укажите сумму договора';
            }
            if (!Datas::checkPole($phone)) {
                $errors[] = 'Введите номер телефона';
            }

            $dubl = Order::getOrdersByParam('contract',$contract);
            if (!empty($dubl)){
                $errors[] = 'Уже есть заказ с таким номером';
            }

            $result = NULL;
            if (!$errors) {
                //вносим в базу
                $result = Order::add($contract, $con_date, $name, $prod, $adress, $phone, $termin, $dis, $sum, $pred, $rassr, $beznal, $note);
            }
        }

        $page = SITE_PATH.'views/new.php';
        include (SITE_PATH.'views/layout.php');

        return true;
    }

    function actionCheckDublication($con)
    {

        $dubl = Order::getOrdersByParam('contract',$con);

        if (!empty($dubl)){
            echo'Уже есть заказ с таким номером';
        }
        return true;
    }
}