<?php
/**
 * Created by PhpStorm.
 * User: kittiwake
 * Date: 23.01.2017
 * Time: 10:41
 */

class Session {

    public $error=null;

    function start()
    {
        if (isset($_POST['auth'])) {
            //проверяем логин-пароль
            if (isset($_POST['login']) && isset($_POST['pass'])) {

                $log = $_POST['login'];
                $pass = $_POST['pass'];
                $res = Users::getUsersByParam('user_login',$log);
                if(empty($res) || $res[0]['user_password']!= md5(md5($pass))){
                    $this->error = 'Invalid login or password';
                }elseif($res[0]['validation']!= 1){
                    $this->error = 'You are denied access';

                }else{
                    session_start();
                    $this->error = 'session started';
                    $_SESSION['ri'] = $res[0]['user_right'];
                    $_SESSION['login'] = $res[0]['user_login'];
                    $_SESSION['uid'] = $res[0]['id'];
                    $_SESSION['internal'] = $res[0]['internal'];

                    $array = array('100','202','203','204');
                    if(array_search($_SESSION['internal'],$array)!==false){
                        $salt = md5($log);
                        $token = md5($salt.time().$log);
                        setcookie('token', $token);
                        setcookie('login', $log);
                        $data = array('role' => $log, 'token' => $token, 'ttl' => 172800);
                        $data = json_encode($data);
                        $socketObj = new Socket();
                        $socket = $socketObj->send('/feedauth',$data);
                    }
                }
            }
        }
        elseif(isset($_GET['out']) && $_GET['out']==1){
            session_start();
            session_unset();
            session_destroy();
            setcookie('PHPSESSID', '', -1);
            header('Location: /');
        }
        elseif(isset($_GET['ajax']) && $_GET['ajax']==1){
            session_start();
            $this->error = 'session started';
        }
        elseif(!empty($_COOKIE['PHPSESSID']) && session_start())
        {
            if(sizeof($_SESSION)>0){
                $this->error = 'session ok';
            }else{
                $this->error = 'You need to log in';
            }
        }
        else{
            $this->error = 'You need to log in';

        }
        return $this->error;
    }
} 