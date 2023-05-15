<?php

class Controller_manpower {
//список кадров
//добавлять, увольнять, редактировать сотрудников
    public function actionIndex(){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $dis_list = Users::getUserByPost(5);
        //получить список штатных
        foreach($dis_list as $key=>$dis){
            if($dis['validation'] == 0){
                unset($dis_list[$key]);
            }
        }

        $coll_list = Users::getUserByPost(17);
        //получить список штатных
        foreach($coll_list as $key=>$dis){
            if($dis['validation'] == 0){
                unset($coll_list[$key]);
            }
        }

        $page = SITE_PATH.'views/manpower.php';
        include (SITE_PATH.'views/layout.php');

        return true;

    }
    public function actionDismiss(){
        $uid = $_POST['uid'];
        $res = Users::updateUsersByParam('validation', 0, $uid);

        echo $res;

        return true;

    }
    public function actionOperate(){
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
//        $pid = 5;
//        $name = 'kjhgfd';
//        $phone = '+79258462627';


        $res = User_post::addNewWorker($name,$phone,$pid);
echo($res);
        return true;

    }

} 