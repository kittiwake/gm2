<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 30.11.2015
 * Time: 17:33
 */

class Controller_staff {
    function actionIndex(){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,3,58);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }

        $style = '<link rel="stylesheet" href="/css/staff.css" title="normal" type="text/css" media="screen" />';
        $script2 = '<script type="text/javascript" src="/scripts/staff.js"></script>';
        $page = SITE_PATH.'views/staff.php';
        include (SITE_PATH.'views/layout.php');
        return true;

    }

    function actionGenpass(){

        $ri = $_SESSION['ri'];
        $log = $_SESSION['login'];

        $allowed = array(1,100);
        if(!in_array($ri,$allowed)){
            die("Нет доступа к этой странице!");
        }
        
        $list = Users::getUsersByParam('validation', 1); //список рабочих
        $baseposts = Posts::getPosts();
     //   debug($list);
        foreach($list as $k=>$user){
            $posts = User_post::getUsersByUID($user['id']);
            $list[$k]['post'] = '';
            foreach($posts as $post){
                $list[$k]['post'] .= $baseposts[$post['pid']] . ', ';
           // debug($post);
            }
        }

        $style = '<link rel="stylesheet" href="/css/staff.css" title="normal" type="text/css" media="screen" />';
    //    $script2 = '<script type="text/javascript" src="/scripts/staff.js"></script>';
        $page = SITE_PATH.'views/genpass.php';
        include (SITE_PATH.'views/layout.php');
        return true;

    }

    function actionGetListUsers(){

        $pid = $_POST['pid'];
//        $pid = 17;
        $list = Users::getUserByPost($pid);
        foreach($list as $key=>$val){
            if($val['validation'] == 0){
                unset($list[$key]);
            }
        }

        echo json_encode($list);
        return true;
    }

    function actionDismissUser(){

        $pid = $_POST['pid'];
        $uid = $_POST['uid'];
//        $pid = 17;
        $list = User_post::getUsersByUID($uid);

        if(count($list) == 1){
            $res = Users::updateUsersByParam('validation', '0', $uid);
        }else{
            $res = User_post::del($uid, $pid);
        }
        return true;
    }

    function actionGetAllNames(){

        $list = Users::getAllUsersNames();

        echo json_encode($list);
        return true;
    }

    function actionAppointUser(){

        $pid = $_POST['pid'];
        $name = $_POST['name'];
        //проверка наличия
        $list = Users::getUsersByParam('name', $name);

        if(count($list) == 0){
            $uid = Users::addUserName($name, $pid);
        }else{
            $uid = $list[0]['id'];
            if($list[0]['validation'] == 0){
                Users::updateUsersByParam('validation', "1", $uid);
            }
        }
        $res = User_post::getUsersByUID($uid);
        $ispara = false;
        foreach($res as $one){
            if($one['pid'] == $pid)
                $ispara = true;
        }
        if(!$ispara){
            User_post::add($uid, $pid);
        }
//        var_dump($res);
        return true;
    }
    
    function actionChangeUserData(){
        $uid = $_POST['uid'];
        $data = $_POST['data'];
        $val = $_POST['val'];
        
        if($data=="user_password"){
           $val = md5(md5($val));
        }
        
        $res = Users::updateUsersByParam($data, $val, $uid);
        
        echo $res;
        return true;
    }
}