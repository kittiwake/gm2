<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 01.06.2018
 * Time: 14:06
 */

class Controller_callmessages {

    function actionIndex(){
        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];
        $int = $_SESSION['internal'];

        if(isset($_POST['submit'])){
            $touser = $_POST['touser'];
            $text = $_POST['textmess'];

            if($touser!=''&&$text!=''){
                $res = Callmess::addNewMessage($touser,$text,$log);
            }
        }

        //список получателей сообщений
        $users = Users::getUsersByParam('validation',1);
        $list = array();
        foreach($users as $user){
            if($user['user_login']==''||$user['name']=='') continue;
            if($user['user_right']!=0){
                $list[$user['user_login']] = $user['name'];
            }
        }
        asort($list);
//        var_dump($list);die;

        $messages = Callmess::getAllMessages($log);

        $this->actionNewToRead();

        $page = SITE_PATH.'views/messages.php';
        include (SITE_PATH.'views/layout.php');
        return true;
    }

    function actionCheckNewMess(){
        $login = $_SESSION['login'];
        $res = Callmess::getNewMessages($login);
        echo count($res);
        return true;
    }

    function actionNewToRead(){
        $login = $_SESSION['login'];
        $res = Callmess::updateNewToRead($login);
        return true;
    }
}